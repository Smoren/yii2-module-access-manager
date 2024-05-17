<?php

namespace Smoren\Yii2\AccessManager\forms\worker_group;

/**
 * Model for updating worker_group
 *
 * @OA\Schema(schema="AccessManager\WorkerGroupUpdateForm", type="object")
 * @OA\Property(
 *     property="alias",
 *     type="string",
 *     example="worker_group_alias",
 *     description="Worker group alias"
 * )
 * @OA\Property(
 *     property="title",
 *     type="string",
 *     example="My worker group name",
 *     description="Worker group name"
 * )
 * @OA\Property(
 *     property="sort",
 *     type="integer",
 *     example="0",
 *     description="Sort index"
 * )
 * @OA\Property(
 *     property="extra",
 *     type="object|null",
 *     example=null,
 *     description="Extra data"
 * )
 */
class WorkerGroupUpdateForm extends WorkerGroupCreateForm
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
