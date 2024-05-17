<?php

namespace Smoren\Yii2\AccessManager\forms\api;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for creating api
 *
 * @OA\Schema(schema="AccessManager\ApiCreateForm", type="object")
 */
class ApiCreateForm extends Model
{
    /**
     * @OA\Property(
     *     property="method",
     *     type="string",
     *     example="get",
     *     description="HTTP method"
     * )
     */
    public $method;
    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     example="/my/api/path",
     *     description="URI path"
     * )
     */
    public $path;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My API name",
     *     description="API name"
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
            [['method', 'path', 'title'], 'required'],
            [['method', 'path', 'title'], 'string'],
            [['sort'], 'integer'],
            [['sort'], 'integer', 'default' => 0],
            [['extra'], 'validateExtra'],
            [['path', 'title'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 10],
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
