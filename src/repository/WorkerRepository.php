<?php

namespace Smoren\Yii2\AccessManager\repository;

use Smoren\Yii2\AccessManager\interfaces\WorkerInterface;
use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Smoren\Yii2\AccessManager\models\Worker;
use Yii;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function getWorkerFromRequestContext(): WorkerInterface
    {
        return new Worker(Yii::$app->user->identity);
    }
}
