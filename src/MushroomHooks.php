<?php

namespace Smoren\Yii2\AccessManager;

/**
 * Class MushroomHooks
 * @package Smoren\Yii2\AccessManager
 */
class MushroomHooks
{
    /**
     * @param $params
     */
    public static function afterInstall($params)
    {
        echo "\e[32m[OK]\e[39m Module 'access' added to your project.\n";

        $configHelp = file_get_contents(__DIR__.'/extra/tpl/config.tpl');

        echo "\nPlease update your yii2 configs and then run migrations:\n\n\e[36m{$configHelp}\e[39m\n\n";
    }
}
