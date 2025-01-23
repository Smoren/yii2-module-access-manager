<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use thamtech\uuid\validators\UuidValidator;

/**
 * Model for api_group filter
 *
 * @OA\Schema(schema="AccessManager\ApiGroupFilterForm", type="object")
 */
class ApiGroupFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="api_group_alias",
     *     description="API group alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="parent_id",
     *     type="string",
     *     example="00000000-0000-0000-000000000000",
     *     description="API group parent_id"
     * )
     */
    public $parent_id;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My API group name",
     *     description="API name"
     * )
     */
    public $title;
    /**
     * @OA\Property(
     *     property="in_menu",
     *     type="bool",
     *     example=false,
     *     description="Include to menu flag"
     * )
     */
    public $in_menu;
    /**
     * @OA\Property(
     *     property="is_system",
     *     type="bool",
     *     example=false,
     *     description="Is system API group flag"
     * )
     */
    public $is_system;
    /**
     * @OA\Property(
     *     property="worker_group_id",
     *     type="string",
     *     example="worker_group_id",
     *     description="Worker group ID"
     * )
     */
    public $worker_group_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'title', 'worker_group_id'], 'string'],
            [['in_menu', 'is_system'], 'boolean'],
            [['parent_id'], UuidValidator::class],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
