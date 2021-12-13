<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

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
 *     property="is_system",
 *     type="bool",
 *     example=false,
 *     description="Is system API group flag"
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
            [['in_menu', 'is_system'], 'boolean'],
            [['in_menu', 'is_system'], 'default', 'value' => false],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
