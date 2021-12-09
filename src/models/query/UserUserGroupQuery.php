<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\UserUserGroup]].
 *
 * @see \Smoren\Yii2\AccessManager\models\UserUserGroup
 */
class UserUserGroupQuery extends \Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery
{
    /**
     * @param $userId
     * @param bool $filter
     * @return UserUserGroupQuery|ActiveQuery
     */
    public function byUser($userId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('user_id') => $userId], $filter);
    }

    /**
     * @param $userGroupId
     * @param bool $filter
     * @return UserUserGroupQuery|ActiveQuery
     */
    public function byUserGroup($userGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('user_group_id') => $userGroupId], $filter);
    }
}
