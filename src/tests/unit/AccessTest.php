<?php

namespace Smoren\Yii2\AccessManager\tests\unit;


use Smoren\Yii2\AccessManager\components\ApiAccessChecker;
use Smoren\Yii2\AccessManager\components\AccessManager;
use Smoren\Yii2\AccessManager\components\RuleAccessChecker;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\Rule;
use Codeception\Test\Unit;
use Smoren\ExtendedExceptions\BadDataException;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;

class AccessTest extends Unit
{
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

        $userGroup1 = AccessManager::createUserGroup('group1', 'test');
        $userGroup2 = AccessManager::createUserGroup('group2', 'test');

        try {
            AccessManager::createUserGroup('group1', 'test');
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $userId1 = $this->createUserId();
        $userId2 = $this->createUserId();

        AccessManager::linkUser($userId1, $userGroup1->id);
        AccessManager::linkUser($userId1, $userGroup2->id);
        AccessManager::linkUser($userId2, $userGroup2->id);

        try {
            AccessManager::linkUser($userId2, $userGroup2->id);
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        $this->checkAccessDenied($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessDenied($userId2, $api2);

        AccessManager::createPermission($apiGroup1->id, $userGroup1->id);
        $this->checkAccessGranted($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessDenied($userId2, $api2);

        AccessManager::createPermission($apiGroup2->id, $userGroup2->id);
        $this->checkAccessGranted($userId1, $api1);
        $this->checkAccessGranted($userId1, $api2);
        $this->checkAccessGranted($userId2, $api1);
        $this->checkAccessGranted($userId2, $api2);

        AccessManager::unlinkUser($userId1, $userGroup2->id);
        $this->checkAccessGranted($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessGranted($userId2, $api1);
        $this->checkAccessGranted($userId2, $api2);

        AccessManager::unlinkApi($api1->id, $apiGroup2->id);
        $this->checkAccessGranted($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessGranted($userId2, $api2);

        AccessManager::deletePermission($apiGroup2->id, $userGroup2->id);
        $this->checkAccessGranted($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessDenied($userId2, $api2);

        AccessManager::deletePermission($apiGroup1->id, $userGroup1->id);
        $this->checkAccessDenied($userId1, $api1);
        $this->checkAccessDenied($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessDenied($userId2, $api2);

        AccessManager::createPermission($apiGroup2->id, $userGroup1->id);
        $this->checkAccessDenied($userId1, $api1);
        $this->checkAccessGranted($userId1, $api2);
        $this->checkAccessDenied($userId2, $api1);
        $this->checkAccessDenied($userId2, $api2);
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

        $userGroup1 = AccessManager::createUserGroup('group1', 'test');
        $userGroup2 = AccessManager::createUserGroup('group2', 'test');

        $userId1 = $this->createUserId();
        $userId2 = $this->createUserId();

        AccessManager::linkUser($userId1, $userGroup1->id);
        AccessManager::linkUser($userId1, $userGroup2->id);
        AccessManager::linkUser($userId2, $userGroup2->id);

        $this->checkRuleDenied($userId1, $rule1);
        $this->checkRuleDenied($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleDenied($userId2, $rule2);

        AccessManager::linkRule($rule1->id, $userGroup1->id);
        $this->checkRuleGranted($userId1, $rule1);
        $this->checkRuleDenied($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleDenied($userId2, $rule2);

        AccessManager::linkRule($rule2->id, $userGroup2->id);
        $this->checkRuleGranted($userId1, $rule1);
        $this->checkRuleGranted($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleGranted($userId2, $rule2);

        try {
            AccessManager::linkRule($rule2->id, $userGroup2->id);
            $this->assertTrue(false);
        } catch(DbException $e) {
            $this->assertTrue(true);
        }

        AccessManager::unlinkRule($rule1->id, $userGroup1->id);
        $this->checkRuleDenied($userId1, $rule1);
        $this->checkRuleGranted($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleGranted($userId2, $rule2);

        AccessManager::unlinkUser($userId1, $userGroup2->id);
        $this->checkRuleDenied($userId1, $rule1);
        $this->checkRuleDenied($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleGranted($userId2, $rule2);

        AccessManager::unlinkRule($rule2->id, $userGroup2->id);
        $this->checkRuleDenied($userId1, $rule1);
        $this->checkRuleDenied($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleDenied($userId2, $rule2);

        AccessManager::linkRule($rule2->id, $userGroup1->id);
        $this->checkRuleDenied($userId1, $rule1);
        $this->checkRuleGranted($userId1, $rule2);
        $this->checkRuleDenied($userId2, $rule1);
        $this->checkRuleDenied($userId2, $rule2);
    }

    protected function checkAccessGranted(string $userId, Api $api)
    {
        $checker = new ApiAccessChecker($api->method, $api->path, $userId);
        $checker->checkAccess();
    }

    protected function checkAccessDenied(string $userId, Api $api)
    {
        try {
            $this->checkAccessGranted($userId, $api);
            $this->assertTrue(false);
        } catch(ApiException $e) {
            $this->assertEquals(StatusCode::FORBIDDEN, $e->getCode());
        }
    }

    protected function checkRuleGranted(string $userId, Rule $rule)
    {
        $checker = new RuleAccessChecker($userId);
        $checker->checkAccess($rule->alias);
    }

    protected function checkRuleDenied(string $userId, Rule $rule)
    {
        try {
            $this->checkRuleGranted($userId, $rule);
            $this->assertTrue(false);
        } catch(ApiException $e) {
            $this->assertEquals(StatusCode::FORBIDDEN, $e->getCode());
        }
    }

    protected function createUserId()
    {
        $userClass = Yii::$app->user->identityClass;

        if(method_exists($userClass, 'createTestUser')) {
            return $userClass::createTestUser();
        }

        try {
            $user = new $userClass();
            $user->email = uniqid().'@'.uniqid().'.com';
            $user->setPassword(uniqid().uniqid().'!@1a');

            if(method_exists($userClass, 'generateAuthKey')) {
                $user->generateAuthKey();
            }

            if(!$user->save()) {
                throw new DbException('caanot create user', 1);
            }

            return $user->id;
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