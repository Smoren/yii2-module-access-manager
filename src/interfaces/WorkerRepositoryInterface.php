<?php

namespace Smoren\Yii2\AccessManager\interfaces;

interface WorkerRepositoryInterface
{
    public function getWorkerFromRequestContext(): WorkerInterface;
}
