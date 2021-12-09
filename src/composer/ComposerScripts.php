<?php


namespace Smoren\Yii2\AccessManager\composer;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class ComposerScripts
{
    public static function postPackageInstall(PackageEvent $event)
    {
        echo "+++++++++++++++++++++++++++++++++++\n\n";
        $installedPackage = $event->getOperation()->getPackage();
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        echo "{$installedPackage}\n{$vendorDir}\n";
        echo "+++++++++++++++++++++++++++++++++++\n\n";
    }
}