<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\AccessManager\models\WorkerGroupRule;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\WorkerGroup]].
 *
 * @see \Smoren\Yii2\AccessManager\models\WorkerGroup
 */
class WorkerGroupQuery extends \Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery
{
    /**
     * @param $alias
     * @param bool $filter
     * @return ActiveQuery|WorkerGroupQuery
     */
    public function byAlias($alias, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('alias') => $alias], $filter);
    }

    /**
     * @param $title
     * @param bool $filter
     * @return ActiveQuery|WorkerGroupQuery
     */
    public function byTitle($title, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('title') => $title], $filter);
    }

    /**
     * @param $workerId
     * @return ActiveQuery|WorkerGroupQuery
     */
    public function byWorker($workerId)
    {
        if (empty($workerId)) {
            return $this;
        }

        $workerGroupIds = WorkerGroup::find()
            ->alias('wg')
            ->innerJoin(['wwg' => WorkerWorkerGroup::tableName()], 'wwg.worker_group_id = wg.id')
            ->andWhere(['wwg.worker_id' => $workerId])
            ->select('wg.id')
            ->column();

        return $this->andWhereExtended([$this->aliasColumn('id') => $workerGroupIds]);
    }

    /**
     * @param $ruleId
     * @return ActiveQuery|WorkerGroupQuery
     */
    public function byRule($ruleId)
    {
        if (empty($ruleId)) {
            return $this;
        }

        $workerGroupIds = WorkerGroup::find()
            ->alias('wg')
            ->innerJoin(['wgr' => WorkerGroupRule::tableName()], 'wgr.worker_group_id = wg.id')
            ->andWhere(['wgr.rule_id' => $ruleId])
            ->select('wg.id')
            ->column();

        return $this->andWhereExtended([$this->aliasColumn('id') => $workerGroupIds]);
    }

    /**
     * @param int $direction
     * @return self
     */
    public function sort(int $direction = SORT_ASC): self
    {
        return $this->orderBy(['sort' => $direction]);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroup
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroup
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerGroup[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
