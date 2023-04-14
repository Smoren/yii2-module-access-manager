<?php

namespace Smoren\Yii2\AccessManager\interfaces;

interface WorkerRepositoryInterface
{
    /**
     * @return array<string>
     */
    public function getWorkerIdsFromRequestContext(): array;
}
