<?php

namespace Smoren\Yii2\AccessManager\forms\user_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for user_group filter
 *
 * @OA\Schema(schema="AccessManager\UserGroupCreateForm", type="object")
 */
class UserGroupFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="user_group_alias",
     *     description="User group alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My user group name",
     *     description="User group name"
     * )
     */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
