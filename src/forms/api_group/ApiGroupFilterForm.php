<?php

namespace Smoren\Yii2\AccessManager\forms\api_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

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
            [['in_menu'], 'boolean'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
