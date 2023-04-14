<?php

namespace Smoren\Yii2\AccessManager\repository;

use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Yii;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function getWorkerIdsFromRequestContext(): array
    {
        return [Yii::$app->user->identity->getId()];
    }
}
