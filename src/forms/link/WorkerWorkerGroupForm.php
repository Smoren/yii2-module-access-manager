<?php

namespace Smoren\Yii2\AccessManager\forms\link;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use thamtech\uuid\validators\UuidValidator;

class WorkerWorkerGroupForm extends Model
{
    /**
     * @var string
     */
    public $worker_id;

    /**
     * @var string
     */
    public $worker_group_id;

    public function rules(): array
    {
        return [
            [['worker_id', 'worker_group_id'], 'required'],
            [['worker_id', 'worker_group_id'], UuidValidator::class],
        ];
    }
}
