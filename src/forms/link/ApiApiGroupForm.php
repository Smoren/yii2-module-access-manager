<?php

namespace Smoren\Yii2\AccessManager\forms\link;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use thamtech\uuid\validators\UuidValidator;

class ApiApiGroupForm extends Model
{
    /**
     * @var string
     */
    public $api_id;

    /**
     * @var string
     */
    public $api_group_id;

    public function rules(): array
    {
        return [
            [['api_id', 'api_group_id'], 'required'],
            [['api_id', 'api_group_id'], UuidValidator::class],
        ];
    }
}
