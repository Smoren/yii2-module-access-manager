<?php


namespace Smoren\Yii2\AccessManager;


use Smoren\Composer\Mushroom\HookManager;
use yii\helpers\BaseFileHelper;

class MushroomHooks
{
    const MODULE_NAME_MASK = 'access';

    public static function afterInstall($params)
    {
        $moduleName = $params['module-name'] ?? 'access';
        $validationRegexp = '/^[a-z_]{3,}$/';

        if(!preg_match($validationRegexp, $moduleName)) {
            echo "\e[33m[WARNING]\e[39m Module name validation failed"
                . " (given: '{$moduleName}', regexp: {$validationRegexp}), skipping hook.\n";
            return;
        }

        $moduleDir = HookManager::PATH_PROJECT.'/modules/'.$moduleName;

        if(is_dir($moduleDir)) {
            echo "\e[33m[WARNING]\e[39m Module '{$moduleName}' already exist in project, skipping hook.\n";
            return;
        }

        BaseFileHelper::copyDirectory(__DIR__.'/../resources/module', $moduleDir);
        BaseFileHelper::copyDirectory(__DIR__.'/migrations', "{$moduleDir}/migrations");

        $filesToUpdate = ['Module.php', 'tests/unit/AccessTest.php', 'migrations'];
        foreach($filesToUpdate as $filePath) {
            $fullFilePath = "{$moduleDir}/{$filePath}";
            if(is_dir($fullFilePath)) {
                $extraFiles = BaseFileHelper::findFiles($fullFilePath, [
                    'filter' => function($fileName) {
                        return preg_match('/\.php$/', $fileName);
                    }
                ]);
                foreach($extraFiles as $extraFileName) {
                    $filesToUpdate[] = "{$fullFilePath}/{$extraFileName}";
                }
            }
            file_put_contents(
                $fullFilePath,
                str_replace(
                    self::MODULE_NAME_MASK, $moduleName, file_get_contents($fullFilePath)
                )
            );
        }

        echo "\e[32m[OK]\e[39m Module '{$moduleName}' added to your project. See '/modules/{$moduleName}/Module.php'.\n";
    }
}
