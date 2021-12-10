<?php


namespace Smoren\Yii2\AccessManager;


use Smoren\Composer\Mushroom\HookManager;
use yii\helpers\BaseFileHelper;

class MushroomHooks
{
    public static function afterInstall($params)
    {
        $moduleName = $params['module-name'] ?? 'access';
        $modulesDir = HookManager::PATH_PROJECT.'/modules';

        if(is_dir("{$modulesDir}/{$moduleName}")) {
            echo "\e[33m[WARNING]\e[39m Module '{$moduleName}' already exist in project, skipping hook.\n";
            return;
        }

        BaseFileHelper::copyDirectory(__DIR__.'/../resources/module', $modulesDir);

        echo "\e[32m[OK]\e[39m Module '{$moduleName}' added to your project. See '/modules/{$moduleName}/Module.php'.\n";
    }
}
