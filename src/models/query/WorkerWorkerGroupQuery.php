<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\WorkerWorkerGroup]].
 *
 * @see \Smoren\Yii2\AccessManager\models\WorkerWorkerGroup
 */
class WorkerWorkerGroupQuery extends \Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery
{
    /**
     * @param $workerId
     * @param bool $filter
     * @return WorkerWorkerGroupQuery|ActiveQuery
     */
    public function byWorker($workerId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('worker_id') => $workerId], $filter);
    }

    /**
     * @param $workerGroupId
     * @param bool $filter
     * @return WorkerWorkerGroupQuery|ActiveQuery
     */
    public function byWorkerGroup($workerGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('worker_group_id') => $workerGroupId], $filter);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerWorkerGroup
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerWorkerGroup
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|WorkerWorkerGroup[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
