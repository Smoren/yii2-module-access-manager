<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\Worker;
use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\Worker]].
 *
 * @see \Smoren\Yii2\AccessManager\models\Worker
 */
class WorkerQuery extends ActiveQuery
{
    /**
     * @param $title
     * @param bool $filter
     * @return ActiveQuery|WorkerQuery
     */
    public function byTitle($title, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('title') => $title], $filter);
    }

    /**
     * @param $workerGroupId
     * @return ActiveQuery|WorkerQuery
     */
    public function byWorkerGroup($workerGroupId)
    {
        if (empty($workerGroupId)) {
            return $this;
        }

        $workerIds = Worker::find()
            ->alias('w')
            ->innerJoin(['wwg' => WorkerWorkerGroup::tableName()], 'wwg.worker_id = w.id')
            ->innerJoin(['wg' => WorkerGroup::tableName()], 'wg.id = wwg.worker_group_id')
            ->andWhere(['wg.id' => $workerGroupId])
            ->select('w.id')
            ->column();

        return $this->andWhereExtended([$this->aliasColumn('id') => array_unique($workerIds)]);
    }

    /**
     * @param Connection|null $db
     * @return array|Worker
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Worker
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Worker[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
