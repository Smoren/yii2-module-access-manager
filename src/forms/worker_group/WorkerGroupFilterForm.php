<?php

namespace Smoren\Yii2\AccessManager\forms\worker_group;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for worker_group filter
 *
 * @OA\Schema(schema="AccessManager\WorkerGroupCreateForm", type="object")
 */
class WorkerGroupFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="alias",
     *     type="string",
     *     example="worker_group_alias",
     *     description="Worker group alias"
     * )
     */
    public $alias;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My worker group name",
     *     description="Worker group name"
     * )
     */
    public $title;
    /**
     * @OA\Property(
     *     property="worker_id",
     *     type="string",
     *     example="worker_id",
     *     description="Worker ID"
     * )
     */
    public $worker_id;
    /**
     * @OA\Property(
     *     property="rule_id",
     *     type="string",
     *     example="rule_id",
     *     description="Rule ID"
     * )
     */
    public $rule_id;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['alias', 'title', 'worker_id', 'rule_id'], 'string'],
            [['alias', 'title'], 'string', 'max' => 255],
        ];
    }
}
