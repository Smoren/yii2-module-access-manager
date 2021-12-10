<?php


namespace Smoren\Yii2\AccessManager;


use Smoren\Composer\Mushroom\HookManager;
use yii\helpers\BaseFileHelper;

class MushroomHooks
{
    const MODULE_NAME_MASK = '__MODULE_NAME__';

    public static function afterInstall($params)
    {
        $moduleName = $params['module-name'] ?? 'access';
        $moduleDir = HookManager::PATH_PROJECT.'/modules/'.$moduleName;

        if(is_dir($moduleDir)) {
            echo "\e[33m[WARNING]\e[39m Module '{$moduleName}' already exist in project, skipping hook.\n";
            return;
        }

        BaseFileHelper::copyDirectory(__DIR__.'/../resources/module', $moduleDir);

        $filesToUpdate = ['Module.php', 'tests/unit/AccessTest.php'];
        foreach($filesToUpdate as $filePath) {
            file_put_contents(
                "{$moduleDir}/{$filePath}",
                str_replace(
                    self::MODULE_NAME_MASK, $moduleName, file_get_contents("{$moduleDir}/{$filePath}")
                )
            );
        }

        echo "\e[32m[OK]\e[39m Module '{$moduleName}' added to your project. See '/modules/{$moduleName}/Module.php'.\n";
    }
}
