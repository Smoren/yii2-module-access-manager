<?php


namespace Smoren\Yii2\AccessManager\controllers;


use Smoren\Yii2\AccessManager\traits\AccessControlTrait;
use Smoren\Yii2\Auth\controllers\UserTokenController;

class IndexController extends UserTokenController
{
    use AccessControlTrait;

    public function actionTest(int $id)
    {
        return ['test' => $id];
    }
}