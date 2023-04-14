<?php

namespace Smoren\Yii2\AccessManager\components;

use Smoren\Yii2\AccessManager\helpers\UrlManagerHelper;
use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\AccessManager\models\WorkerGroupRule;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\ExtendedExceptions\BaseException;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;
use yii\base\BaseObject;
use yii\db\Connection;
use yii\db\Query;

class RuleAccessChecker
{
    /**
     * @var array<string>
     */
    protected $workerIds;
    /**
     * @var Connection
     */
    protected $dbConn;

    public static function createFromRequestContext(?Connection $dbConn = null): self
    {
        return new static(
            Yii::createObject(WorkerRepositoryInterface::class)->getWorkerIdsFromRequestContext(),
            $dbConn
        );
    }

    public function __construct(array $workerIds, ?Connection $dbConn = null)
    {
        $this->workerIds = $workerIds;
        $this->dbConn = $dbConn ?? Yii::$app->db;
    }

    public function checkAccess(string $ruleAlias): self
    {
        $grantCount = (new Query())
            ->select('ugr.rule_id')
            ->from(['r' => Rule::tableName()])
            ->innerJoin(['ugr' => WorkerGroupRule::tableName()], 'ugr.rule_id = r.id')
            ->innerJoin(['ug' => WorkerGroup::tableName()], 'ug.id = ugr.worker_group_id')
            ->innerJoin(['uug' => WorkerWorkerGroup::tableName()], 'uug.worker_group_id = ug.id')
            ->andWhere(['uug.worker_id' => $this->workerIds])
            ->andWhere(['r.alias' => $ruleAlias])
            ->count('ugr.rule_id', $this->dbConn);

        if(!$grantCount) {
            throw new ApiException('access denied', StatusCode::FORBIDDEN);
        }

        return $this;
    }
}
