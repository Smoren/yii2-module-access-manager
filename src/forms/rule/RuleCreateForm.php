<?php

namespace Smoren\Yii2\AccessManager\forms\rule;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for creating rule
 *
 * @OA\Schema(schema="AccessManager\RuleCreateForm", type="object")
 */
class RuleCreateForm extends Model
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
            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 0],
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
