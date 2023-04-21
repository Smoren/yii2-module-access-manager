<?php

namespace Smoren\Yii2\AccessManager\forms\api;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for api filter
 *
 * @OA\Schema(schema="AccessManager\ApiFilterForm", type="object")
 */
class ApiFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="api_group_id",
     *     type="string",
     *     example="be8e3349-d4e5-4fea-93f7-25a0dc10c9ca",
     *     description="API group ID"
     * )
     */
    public $api_group_id;
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method', 'path', 'title', 'api_group_id'], 'string'],
            [['path', 'title'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 10],
        ];
    }
}
