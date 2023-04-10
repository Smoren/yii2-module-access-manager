<?php

namespace Smoren\Yii2\AccessManager\components;

use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\AccessManager\models\WorkerGroupRule;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;

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

    public static function createWorkerGroup(string $alias, string $title, ?array $extra = null): WorkerGroup
    {
        $workerGroup = new WorkerGroup([
            'alias' => $alias,
            'title' => $title,
            'extra' => $extra,
        ]);
        $workerGroup->save();

        return $workerGroup;
    }

    public static function linkWorker(string $workerId, string $workerGroupId): WorkerWorkerGroup
    {
        $link = new WorkerWorkerGroup([
            'worker_id' => $workerId,
            'worker_group_id' => $workerGroupId,
        ]);
        $link->save();

        return $link;
    }

    public static function unlinkWorker(string $workerId, string $workerGroupId): WorkerWorkerGroup
    {
        $link = static::getWorkerLink($workerId, $workerGroupId);
        $link->delete();

        return $link;
    }

    public static function getWorkerLink(string $workerId, string $workerGroupId): WorkerWorkerGroup
    {
        return WorkerWorkerGroup::find()->byWorker($workerId)->byWorkerGroup($workerGroupId)->one();
    }

    public static function createPermission(string $apiGroupId, string $workerGroupId): Permission
    {
        $permission = new Permission([
            'api_group_id' => $apiGroupId,
            'worker_group_id' => $workerGroupId,
        ]);
        $permission->save();

        return $permission;
    }

    public static function deletePermission(string $apiGroupId, string $workerGroupId): Permission
    {
        $permission = static::getPermission($apiGroupId, $workerGroupId);
        $permission->delete();

        return $permission;
    }

    public static function getPermission(string $apiGroupId, string $workerGroupId): Permission
    {
        return Permission::find()->byApiGroup($apiGroupId)->byWorkerGroup($workerGroupId)->one();
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

    public static function linkRule(string $ruleId, string $workerGroupId): WorkerGroupRule
    {
        $link = new WorkerGroupRule([
            'worker_group_id' => $workerGroupId,
            'rule_id' => $ruleId,
        ]);
        $link->save();

        return $link;
    }

    public static function unlinkRule(string $ruleId, string $workerGroupId): WorkerGroupRule
    {
        $link = static::getRuleLink($ruleId, $workerGroupId);
        $link->delete();

        return $link;
    }

    public static function getRuleLink(string $ruleId, string $workerGroupId): WorkerGroupRule
    {
        return WorkerGroupRule::find()->byWorkerGroup($workerGroupId)->byRule($ruleId)->one();
    }
}
