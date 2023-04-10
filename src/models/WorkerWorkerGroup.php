<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerWorkerGroupQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\AccessManager\validators\PolytypicIdValidator;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_worker_worker_group".
 *
 * @property string $worker_id
 * @property string $worker_group_id
 * @property int $created_at
 *
 * @property WorkerGroup $workerGroup
 */
class WorkerWorkerGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_worker_worker_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['worker_id', 'worker_group_id'], PolytypicIdValidator::class],
            [['worker_id', 'worker_group_id'], 'required'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['worker_id', 'worker_group_id'], 'unique', 'targetAttribute' => ['worker_id', 'worker_group_id']],
            [['worker_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkerGroup::class, 'targetAttribute' => ['worker_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'worker_id' => 'Worker ID',
            'worker_group_id' => 'Worker Group ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[WorkerGroup]].
     *
     * @return ActiveQuery|WorkerGroupQuery
     */
    public function getWorkerGroup()
    {
        return $this->hasOne(WorkerGroup::class, ['id' => 'worker_group_id']);
    }

    /**
     * {@inheritdoc}
     * @return WorkerWorkerGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkerWorkerGroupQuery(get_called_class());
    }
}
