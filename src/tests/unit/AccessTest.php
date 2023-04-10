<?php

namespace Smoren\Yii2\AccessManager\tests\unit;


use Smoren\Yii2\AccessManager\components\ApiAccessChecker;
use Smoren\Yii2\AccessManager\components\AccessManager;
use Smoren\Yii2\AccessManager\components\RuleAccessChecker;
use Smoren\Yii2\AccessManager\interfaces\WorkerInterface;
use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\Rule;
use Codeception\Test\Unit;
use Smoren\Yii2\AccessManager\models\Worker;
use Smoren\Yii2\AccessManager\repository\WorkerRepository;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;

class AccessTest extends Unit
{
    protected function setUp(): void
    {
        parent::setUp();
        Yii::$container->set(WorkerRepositoryInterface::class, WorkerRepository::class);
        Yii::$container->set(WorkerInterface::class, Worker::class);
    }

    public function testApiAccess()
    {
        $api1 = AccessManager::createApi('get', '/api1', 'test');
        $api2 = AccessManager::createApi('get', '/api2', 'test');

        try {
            AccessManager::createApi('get', '/api1', 'test');
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $apiGroup1 = AccessManager::createApiGroup('group1', 'test');
        $apiGroup2 = AccessManager::createApiGroup('group2', 'test');
        try {
            AccessManager::createApiGroup('group1', 'test');
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        AccessManager::linkApi($api1->id, $apiGroup1->id);
        AccessManager::linkApi($api1->id, $apiGroup2->id);
        AccessManager::linkApi($api2->id, $apiGroup2->id);

        try {
            AccessManager::linkApi($api2->id, $apiGroup2->id);
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $workerGroup1 = AccessManager::createWorkerGroup('group1', 'test');
        $workerGroup2 = AccessManager::createWorkerGroup('group2', 'test');

        try {
            AccessManager::createWorkerGroup('group1', 'test');
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $workerId1 = $this->createWorkerId();
        $workerId2 = $this->createWorkerId();

        AccessManager::linkWorker($workerId1, $workerGroup1->id);
        AccessManager::linkWorker($workerId1, $workerGroup2->id);
        AccessManager::linkWorker($workerId2, $workerGroup2->id);

        try {
            AccessManager::linkWorker($workerId2, $workerGroup2->id);
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $this->checkAccessDenied($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessDenied($workerId2, $api2);

        AccessManager::createPermission($apiGroup1->id, $workerGroup1->id);
        $this->checkAccessGranted($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessDenied($workerId2, $api2);

        AccessManager::createPermission($apiGroup2->id, $workerGroup2->id);
        $this->checkAccessGranted($workerId1, $api1);
        $this->checkAccessGranted($workerId1, $api2);
        $this->checkAccessGranted($workerId2, $api1);
        $this->checkAccessGranted($workerId2, $api2);

        AccessManager::unlinkWorker($workerId1, $workerGroup2->id);
        $this->checkAccessGranted($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessGranted($workerId2, $api1);
        $this->checkAccessGranted($workerId2, $api2);

        AccessManager::unlinkApi($api1->id, $apiGroup2->id);
        $this->checkAccessGranted($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessGranted($workerId2, $api2);

        AccessManager::deletePermission($apiGroup2->id, $workerGroup2->id);
        $this->checkAccessGranted($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessDenied($workerId2, $api2);

        AccessManager::deletePermission($apiGroup1->id, $workerGroup1->id);
        $this->checkAccessDenied($workerId1, $api1);
        $this->checkAccessDenied($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessDenied($workerId2, $api2);

        AccessManager::createPermission($apiGroup2->id, $workerGroup1->id);
        $this->checkAccessDenied($workerId1, $api1);
        $this->checkAccessGranted($workerId1, $api2);
        $this->checkAccessDenied($workerId2, $api1);
        $this->checkAccessDenied($workerId2, $api2);
    }

    public function testRuleAccess()
    {
        $rule1 = AccessManager::createRule('rule1', 'test');
        $rule2 = AccessManager::createRule('rule2', 'test');

        try {
            AccessManager::createRule('rule1', 'test');
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $workerGroup1 = AccessManager::createWorkerGroup('group1', 'test');
        $workerGroup2 = AccessManager::createWorkerGroup('group2', 'test');

        $workerId1 = $this->createWorkerId();
        $workerId2 = $this->createWorkerId();

        AccessManager::linkWorker($workerId1, $workerGroup1->id);
        AccessManager::linkWorker($workerId1, $workerGroup2->id);
        AccessManager::linkWorker($workerId2, $workerGroup2->id);

        $this->checkRuleDenied($workerId1, $rule1);
        $this->checkRuleDenied($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleDenied($workerId2, $rule2);

        AccessManager::linkRule($rule1->id, $workerGroup1->id);
        $this->checkRuleGranted($workerId1, $rule1);
        $this->checkRuleDenied($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleDenied($workerId2, $rule2);

        AccessManager::linkRule($rule2->id, $workerGroup2->id);
        $this->checkRuleGranted($workerId1, $rule1);
        $this->checkRuleGranted($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleGranted($workerId2, $rule2);

        try {
            AccessManager::linkRule($rule2->id, $workerGroup2->id);
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        AccessManager::unlinkRule($rule1->id, $workerGroup1->id);
        $this->checkRuleDenied($workerId1, $rule1);
        $this->checkRuleGranted($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleGranted($workerId2, $rule2);

        AccessManager::unlinkWorker($workerId1, $workerGroup2->id);
        $this->checkRuleDenied($workerId1, $rule1);
        $this->checkRuleDenied($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleGranted($workerId2, $rule2);

        AccessManager::unlinkRule($rule2->id, $workerGroup2->id);
        $this->checkRuleDenied($workerId1, $rule1);
        $this->checkRuleDenied($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleDenied($workerId2, $rule2);

        AccessManager::linkRule($rule2->id, $workerGroup1->id);
        $this->checkRuleDenied($workerId1, $rule1);
        $this->checkRuleGranted($workerId1, $rule2);
        $this->checkRuleDenied($workerId2, $rule1);
        $this->checkRuleDenied($workerId2, $rule2);
    }

    protected function checkAccessGranted(string $workerId, Api $api)
    {
        $checker = new ApiAccessChecker($api->method, $api->path, $workerId);
        $checker->checkAccess();
    }

    protected function checkAccessDenied(string $workerId, Api $api)
    {
        try {
            $this->checkAccessGranted($workerId, $api);
            $this->assertTrue(false);
        } catch(ApiException $e) {
            $this->assertEquals(StatusCode::FORBIDDEN, $e->getCode());
        }
    }

    protected function checkRuleGranted(string $workerId, Rule $rule)
    {
        $checker = new RuleAccessChecker($workerId);
        $checker->checkAccess($rule->alias);
    }

    protected function checkRuleDenied(string $workerId, Rule $rule)
    {
        try {
            $this->checkRuleGranted($workerId, $rule);
            $this->assertTrue(false);
        } catch(ApiException $e) {
            $this->assertEquals(StatusCode::FORBIDDEN, $e->getCode());
        }
    }

    protected function createWorkerId()
    {
        $workerClass = Yii::$app->worker->identityClass;

        if(method_exists($workerClass, 'createTestWorker')) {
            return $workerClass::createTestWorker();
        }

        try {
            $worker = new $workerClass();
            $worker->email = uniqid().'@'.uniqid().'.com';
            $worker->setPassword(uniqid().uniqid().'!@1a');

            if(method_exists($workerClass, 'generateAuthKey')) {
                $worker->generateAuthKey();
            }

            if(!$worker->save()) {
                throw new DbException('caanot create worker', 1);
            }

            return $worker->id;
        } catch(DbException $e) {
            return $this->generatePseudoUuid();
        }
    }

    protected function generatePseudoUuid(): string
    {
        $data = random_bytes(16);

        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
