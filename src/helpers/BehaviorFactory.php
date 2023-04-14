<?php

namespace Smoren\Yii2\AccessManager\helpers;

use Smoren\Yii2\AccessManager\interfaces\BehaviorFactoryInterface;

class BehaviorFactory implements BehaviorFactoryInterface
{
    public function getBehaviors(): array
    {
        return [];
    }
}
