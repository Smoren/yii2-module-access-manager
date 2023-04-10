<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

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
}
