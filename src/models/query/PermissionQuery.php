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
     * @param $userGroupId
     * @param bool $filter
     * @return PermissionQuery|ActiveQuery
     */
    public function byUserGroup($userGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('user_group_id') => $userGroupId], $filter);
    }
}
