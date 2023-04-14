<?php

namespace Smoren\Yii2\AccessManager\forms\link;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use thamtech\uuid\validators\UuidValidator;

class WorkerGroupRuleForm extends Model
{
    /**
     * @var string
     */
    public $worker_group_id;

    /**
     * @var string
     */
    public $rule_id;

    public function rules()
    {
        return [
            [['worker_group_id', 'rule_id'], 'required'],
            [['worker_group_id', 'rule_id'], UuidValidator::class]
        ];
    }
}
