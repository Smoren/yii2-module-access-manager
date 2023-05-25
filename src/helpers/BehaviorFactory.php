<?php

namespace Smoren\Yii2\AccessManager\helpers;

use Smoren\Yii2\AccessManager\filters\AccessControlFilter;
use Smoren\Yii2\AccessManager\interfaces\BehaviorFactoryInterface;
use Smoren\Yii2\ActiveRecordExplicit\components\ActiveDataProvider;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\data\BaseDataProvider;

class BehaviorFactory implements BehaviorFactoryInterface
{
    public function getBehaviors(): array
    {
        return [
            'access' => AccessControlFilter::class,
        ];
    }

    public function getListDataProvider(ActiveQuery $query): BaseDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
