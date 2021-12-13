<?php

namespace Smoren\Yii2\AccessManager\forms\api;

/**
 * Model for updating api
 *
 * @OA\Schema(schema="AccessManager\ApiUpdateForm", type="object")
 * @OA\Property(
 *     property="method",
 *     type="string",
 *     example="get",
 *     description="HTTP method"
 * )
 * @OA\Property(
 *     property="path",
 *     type="string",
 *     example="/my/api/path",
 *     description="URI path"
 * )
 * @OA\Property(
 *     property="title",
 *     type="string",
 *     example="My API name",
 *     description="API name"
 * )
 * @OA\Property(
 *     property="extra",
 *     type="object|null",
 *     example=null,
 *     description="Extra data"
 * )
 */
class ApiUpdateForm extends ApiCreateForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method', 'path', 'title'], 'string'],
            [['extra'], 'validateExtra'],
            [['path', 'title'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 10],
        ];
    }
}
