<?php

namespace Smoren\Yii2\AccessManager\forms\rule;

/**
 * Model for updating rule
 *
 * @OA\Schema(schema="AccessManager\RuleUpdateForm", type="object")
 * @OA\Property(
 *     property="alias",
 *     type="string",
 *     example="rule_alias",
 *     description="Rule alias"
 * )
 * @OA\Property(
 *     property="title",
 *     type="string",
 *     example="My rule name",
 *     description="Rule name"
 * )
 * @OA\Property(
 *     property="extra",
 *     type="object|null",
 *     example=null,
 *     description="Extra data"
 * )
 * @OA\Property(
 *     property="sort",
 *     type="integer",
 *     example="0",
 *     description="Sort index"
 * )
 */
class RuleUpdateForm extends RuleCreateForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string'],
            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 0],
            [['extra'], 'validateExtra'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
