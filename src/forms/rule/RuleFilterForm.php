<?php

namespace Smoren\Yii2\AccessManager\forms\rule;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for rule filter
 *
 * @OA\Schema(schema="AccessManager\RuleFilterForm", type="object")
 */
class RuleFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="rule_alias",
     *     description="Rule alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My rule name",
     *     description="Rule name"
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
