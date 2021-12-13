<?php

namespace Smoren\Yii2\AccessManager\forms\user_group;

/**
 * Model for updating user_group
 *
 * @OA\Schema(schema="AccessManager\UserGroupUpdateForm", type="object")
 * @OA\Property(
 *     property="alias",
 *     type="string",
 *     example="user_group_alias",
 *     description="User group alias"
 * )
 * @OA\Property(
 *     property="title",
 *     type="string",
 *     example="My user group name",
 *     description="User group name"
 * )
 * @OA\Property(
 *     property="extra",
 *     type="object|null",
 *     example=null,
 *     description="Extra data"
 * )
 */
class UserGroupUpdateForm extends UserGroupCreateForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string'],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
