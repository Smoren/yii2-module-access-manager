<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

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
}
