<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\Permission]].
 *
 * @see \Smoren\Yii2\AccessManager\models\Permission
 */
class PermissionQuery extends ActiveQuery
{
    /**
     * @param $apiGroupId
     * @param bool $filter
     * @return PermissionQuery|ActiveQuery
     */
    public function byApiGroup($apiGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('api_group_id') => $apiGroupId], $filter);
    }

    /**
     * @param $workerGroupId
     * @param bool $filter
     * @return PermissionQuery|ActiveQuery
     */
    public function byWorkerGroup($workerGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('worker_group_id') => $workerGroupId], $filter);
    }

    /**
     * @param Connection|null $db
     * @return array|Permission
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Permission
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Permission[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
