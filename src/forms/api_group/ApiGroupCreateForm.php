<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for creating api_group
 *
 * @OA\Schema(schema="AccessManager\ApiGroupCreateForm", type="object")
 */
class ApiGroupCreateForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="api_group_alias",
     *     description="API group alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My API group name",
     *     description="API group name"
     * )
     */
    public $title;
    /**
     * @OA\Property(
     *     property="in_menu",
     *     type="bool",
     *     example=false,
     *     description="Include to menu flag"
     * )
     */
    public $in_menu;
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
            [['in_menu'], 'boolean'],
            [['in_menu'], 'default', 'value' => false],
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
