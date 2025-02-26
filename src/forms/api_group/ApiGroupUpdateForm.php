<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

use thamtech\uuid\validators\UuidValidator;

/**
 * Model for updating api_group
 *
 * @OA\Schema(schema="AccessManager\ApiGroupUpdateForm", type="object")
 * @OA\Property(
 *     property="alias",
 *     type="string",
 *     example="api_group_alias",
 *     description="API group alias"
 * )
 * @OA\Property(
 *     property="parent_id",
 *     type="string",
 *     example="00000000-0000-0000-000000000000",
 *     description="API group parent_id"
 * )
 * @OA\Property(
 *     property="title",
 *     type="string",
 *     example="My API group name",
 *     description="API group name"
 * )
 * @OA\Property(
 *     property="in_menu",
 *     type="bool",
 *     example=false,
 *     description="Include to menu flag"
 * )
 * @OA\Property(
 *     property="sort",
 *     type="integer",
 *     example="0",
 *     description="Sort index"
 * )
 */
class ApiGroupUpdateForm extends ApiGroupCreateForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string'],
            [['parent_id'], UuidValidator::class],
            [['in_menu', 'is_secured'], 'boolean'],
            [['in_menu'], 'default', 'value' => false],
            [['is_secured'], 'default', 'value' => true],
            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 0],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
