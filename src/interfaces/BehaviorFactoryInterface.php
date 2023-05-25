<?php

namespace Smoren\Yii2\AccessManager\interfaces;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\data\BaseDataProvider;

interface BehaviorFactoryInterface
{
    public function getBehaviors(): array;

    public function getListDataProvider(ActiveQuery $query): BaseDataProvider;
}
