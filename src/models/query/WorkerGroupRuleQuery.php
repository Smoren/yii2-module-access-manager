<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\WorkerGroupRule;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\WorkerGroupRule]].
 *
 * @see \Smoren\Yii2\AccessManager\models\WorkerGroupRule
 */
class WorkerGroupRuleQuery extends ActiveQuery
{
    /**
     * @param $ruleId
     * @param bool $filter
     * @return WorkerGroupRuleQuery|ActiveQuery
     */
    public function byRule($ruleId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('rule_id') => $ruleId], $filter);
    }

    /**
     * @param $workerGroupId
     * @param bool $filter
     * @return WorkerGroupRuleQuery|ActiveQuery
     */
    public function byWorkerGroup($workerGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('worker_group_id') => $workerGroupId], $filter);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroupRule
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroupRule
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroupRule[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
