<?php

namespace Smoren\Yii2\AccessManager\components;

use Smoren\Yii2\AccessManager\helpers\UrlManagerHelper;
use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;
use yii\db\Connection;
use yii\db\Query;

class ApiAccessChecker
{
    protected $method;
    protected $path;
    protected $workerIds;
    protected $dbConn;
    protected $methodsExcept = [];

    public static function createFromRequestContext(?Connection $dbConn = null): self
    {
        [$method, $path] = UrlManagerHelper::getSummary();
        return new static(
            $method,
            $path,
            Yii::createObject(WorkerRepositoryInterface::class)->getWorkerIdsFromRequestContext(),
            $dbConn
        );
    }

    public function __construct(string $method, string $path, array $workerIds, ?Connection $dbConn = null)
    {
        $this->method = $method;
        $this->path = $path;
        $this->workerIds = $workerIds;
        $this->dbConn = $dbConn ?? Yii::$app->db;
    }

    public function exceptMethods(array $methods): self
    {
        $this->methodsExcept = $methods;
        return $this;
    }

    public function checkAccess(): self
    {
        if(in_array($this->method, $this->methodsExcept)) {
            return $this;
        }

        $grantCount = (new Query())
            ->select('p.api_group_id')
            ->from(['a' => Api::tableName()])
            ->innerJoin(['aag' => ApiApiGroup::tableName()], 'aag.api_id = a.id')
            ->innerJoin(['ag' => ApiGroup::tableName()], 'ag.id = aag.api_group_id')
            ->andWhere(['a.method' => $this->method])
            ->andWhere(['a.path' => $this->path])
            ->andWhere(['ag.is_secured' => false])
            ->count();

        if($grantCount) {
            return $this;
        }

        $grantCount = (new Query())
            ->select('p.api_group_id')
            ->from(['a' => Api::tableName()])
            ->innerJoin(['aag' => ApiApiGroup::tableName()], 'aag.api_id = a.id')
            ->innerJoin(['ag' => ApiGroup::tableName()], 'ag.id = aag.api_group_id')
            ->innerJoin(['p' => Permission::tableName()], 'p.api_group_id = ag.id')
            ->innerJoin(['ug' => WorkerGroup::tableName()], 'ug.id = p.worker_group_id')
            ->innerJoin(['uug' => WorkerWorkerGroup::tableName()], 'uug.worker_group_id = ug.id')
            ->andWhere(['uug.worker_id' => $this->workerIds])
            ->andWhere(['a.method' => $this->method])
            ->andWhere(['a.path' => $this->path])
            ->count('p.api_group_id', $this->dbConn);

        if($grantCount) {
            return $this;
        }

        throw new ApiException('access denied', StatusCode::FORBIDDEN);
    }

    public function checkRule(string $ruleAlias): self
    {
        (new RuleAccessChecker($this->workerIds, $this->dbConn))->checkAccess($ruleAlias);
        return $this;
    }
}
