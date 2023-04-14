<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\interfaces\BehaviorFactoryInterface;
use Smoren\Yii2\Auth\controllers\BaseController;
use Yii;

abstract class CommonController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            $this->getBehaviorFactory()->getBehaviors()
        );
    }

    protected function getBehaviorFactory(): BehaviorFactoryInterface
    {
        return Yii::createObject(BehaviorFactoryInterface::class);
    }
}
