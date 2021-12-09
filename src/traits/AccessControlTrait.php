<?php


namespace Smoren\Yii2\AccessManager\traits;


use Smoren\Yii2\AccessManager\filters\AccessControlFilter;

trait AccessControlTrait
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => AccessControlFilter::class,
        ]);
    }
}