<?php

namespace Smoren\Yii2\AccessManager\forms\worker_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for creating worker_group
 *
 * @OA\Schema(schema="AccessManager\WorkerGroupCreateForm", type="object")
 */
class WorkerGroupCreateForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="worker_group_alias",
     *     description="Worker group alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My worker group name",
     *     description="Worker group name"
     * )
     */
    public $title;
    /**
     * @OA\Property(
     *     property="extra",
     *     type="object|null",
     *     example=null,
     *     description="Extra data"
     * )
     */
    public $extra;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'required'],
            [['alias', 'title'], 'string'],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $attribute
     */
    public function validateExtra($attribute)
    {
        if(strlen(json_encode($this->{$attribute})) > 10000) {
            $this->addError($attribute, 'Extra data is too large (more than 10000 bytes)');
        }
    }
}
