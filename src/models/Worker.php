<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\interfaces\WorkerInterface;
use yii\web\IdentityInterface;

class Worker implements WorkerInterface
{
    /**
     * @var IdentityInterface
     */
    protected $identity;

    public function __construct(IdentityInterface $identity)
    {
        $this->identity = $identity;
    }

    public function getId(): string
    {
        return $this->identity->getId();
    }
}
