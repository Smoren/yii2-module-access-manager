<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use thamtech\uuid\validators\UuidValidator;

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
     *     property="parent_id",
     *     type="string",
     *     example="00000000-0000-0000-000000000000",
     *     description="API group parent_id"
     * )
     */
    public $parent_id;
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
     *     property="in_menu",
     *     type="bool",
     *     example=false,
     *     description="Include to menu flag"
     * )
     */
    public $is_secured;
    /**
     * @OA\Property(
     *     property="sort",
     *     type="integer",
     *     example="0",
     *     description="Sort index"
     * )
     */
    public $sort;
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
            [['parent_id'], UuidValidator::class],
            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 0],
            [['in_menu', 'is_secured'], 'boolean'],
            [['in_menu'], 'default', 'value' => false],
            [['is_secured'], 'default', 'value' => true],
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
