<?php

namespace Smoren\Yii2\AccessManager\forms\worker;

use Smoren\Yii2\ActiveRecordExplicit\models\Model;

/**
 * Model for worker filter
 *
 * @OA\Schema(schema="AccessManager\WorkerFilterForm", type="object")
 */
class WorkerFilterForm extends Model
{
    /**
     * @OA\Property(
     *     property="worker_group_id",
     *     type="string",
     *     example="be8e3349-d4e5-4fea-93f7-25a0dc10c9ca",
     *     description="Worker group ID"
     * )
     */
    public $worker_group_id;
    /**
     * @OA\Property(
     *     property="title",
     *     type="string",
     *     example="My Worker name",
     *     description="Worker name"
     * )
     */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'worker_group_id'], 'string'],
            [[ 'title'], 'string', 'max' => 255],
        ];
    }
}
