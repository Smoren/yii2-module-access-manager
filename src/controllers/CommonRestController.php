<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use yii\data\BaseDataProvider;

abstract class CommonRestController extends CommonController
{
    use RestControllerTrait;

    protected function getDataProvider(ActiveQuery $query): BaseDataProvider
    {
        return $this->getBehaviorFactory()->getListDataProvider($query);
    }
}
