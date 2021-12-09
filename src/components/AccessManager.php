<?php


namespace Smoren\Yii2\AccessManager\components;


use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\AccessManager\models\UserGroup;
use Smoren\Yii2\AccessManager\models\UserGroupRule;
use Smoren\Yii2\AccessManager\models\UserUserGroup;

class AccessManager
{
    public static function createApi(string $method, string $path, string $title, ?array $extra = null): Api
    {
        $api = new Api([
            'method' => $method,
            'path' => $path,
            'title' => $title,
            'extra' => $extra,
        ]);
        $api->save();

        return $api;
    }

    public static function createApiGroup(
        string $alias, string $title, bool $in_menu = false, bool $is_system = false, ?array $extra = null
    ): ApiGroup
    {
        $apiGroup = new ApiGroup([
            'alias' => $alias,
            'title' => $title,
            'in_menu' => $in_menu,
            'is_system' => $is_system,
            'extra' => $extra,
        ]);
        $apiGroup->save();

        return $apiGroup;
    }

    public static function linkApi(string $apiId, string $apiGroupId): ApiApiGroup
    {
        $link = new ApiApiGroup([
            'api_id' => $apiId,
            'api_group_id' => $apiGroupId,
        ]);
        $link->save();

        return $link;
    }

    public static function unlinkApi(string $apiId, string $apiGroupId): ApiApiGroup
    {
        $link = static::getApiLink($apiId, $apiGroupId);
        $link->delete();

        return $link;
    }

    public static function getApiLink(string $apiId, string $apiGroupId): ApiApiGroup
    {
        return ApiApiGroup::find()->byApi($apiId)->byApiGroup($apiGroupId)->one();
    }

    public static function createUserGroup(string $alias, string $title, ?array $extra = null): UserGroup
    {
        $userGroup = new UserGroup([
            'alias' => $alias,
            'title' => $title,
            'extra' => $extra,
        ]);
        $userGroup->save();

        return $userGroup;
    }

    public static function linkUser(string $userId, string $userGroupId): UserUserGroup
    {
        $link = new UserUserGroup([
            'user_id' => $userId,
            'user_group_id' => $userGroupId,
        ]);
        $link->save();

        return $link;
    }

    public static function unlinkUser(string $userId, string $userGroupId): UserUserGroup
    {
        $link = static::getUserLink($userId, $userGroupId);
        $link->delete();

        return $link;
    }

    public static function getUserLink(string $userId, string $userGroupId): UserUserGroup
    {
        return UserUserGroup::find()->byUser($userId)->byUserGroup($userGroupId)->one();
    }

    public static function createPermission(string $apiGroupId, string $userGroupId): Permission
    {
        $permission = new Permission([
            'api_group_id' => $apiGroupId,
            'user_group_id' => $userGroupId,
        ]);
        $permission->save();

        return $permission;
    }

    public static function deletePermission(string $apiGroupId, string $userGroupId): Permission
    {
        $permission = static::getPermission($apiGroupId, $userGroupId);
        $permission->delete();

        return $permission;
    }

    public static function getPermission(string $apiGroupId, string $userGroupId): Permission
    {
        return Permission::find()->byApiGroup($apiGroupId)->byUserGroup($userGroupId)->one();
    }

    public static function createRule(string $alias, string $title): Rule
    {
        $rule = new Rule([
            'alias' => $alias,
            'title' => $title,
        ]);
        $rule->save();

        return $rule;
    }

    public static function deleteRule(string $alias): Rule
    {
        $rule = static::getRule($alias);
        $rule->delete();

        return $rule;
    }

    public static function getRule(string $alias): Rule
    {
        return Rule::find()->byAlias($alias)->one();
    }

    public static function linkRule(string $ruleId, string $userGroupId): UserGroupRule
    {
        $link = new UserGroupRule([
            'user_group_id' => $userGroupId,
            'rule_id' => $ruleId,
        ]);
        $link->save();

        return $link;
    }

    public static function unlinkRule(string $ruleId, string $userGroupId): UserGroupRule
    {
        $link = static::getRuleLink($ruleId, $userGroupId);
        $link->delete();

        return $link;
    }

    public static function getRuleLink(string $ruleId, string $userGroupId): UserGroupRule
    {
        return UserGroupRule::find()->byUserGroup($userGroupId)->byRule($ruleId)->one();
    }
}
