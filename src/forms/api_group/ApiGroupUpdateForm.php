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
            [['in_menu', 'is_secured'], 'boolean'],
            [['in_menu'], 'default', 'value' => false],
            [['is_secured'], 'default', 'value' => true],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
