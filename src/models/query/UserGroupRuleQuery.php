<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\UserGroupRule]].
 *
 * @see \Smoren\Yii2\AccessManager\models\UserGroupRule
 */
class UserGroupRuleQuery extends ActiveQuery
{
    /**
     * @param $ruleId
     * @param bool $filter
     * @return UserGroupRuleQuery|ActiveQuery
     */
    public function byRule($ruleId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('rule_id') => $ruleId], $filter);
    }

    /**
     * @param $userGroupId
     * @param bool $filter
     * @return UserGroupRuleQuery|ActiveQuery
     */
    public function byUserGroup($userGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('user_group_id') => $userGroupId], $filter);
    }
}
