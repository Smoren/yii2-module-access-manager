<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Helpers\EnvHelper;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerWorkerGroupQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_worker".
 *
 * @property string $id
 * @property string $title
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property WorkerWorkerGroup[] $apiApiGroups
 * @property WorkerGroup[] $apiGroups
 */
class Worker extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return EnvHelper::get('ACCESS_WORKER_TABLE', 'process_hierarchy_role');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', UuidValidator::class],
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[WorkerWorkerGroups]].
     *
     * @return ActiveQuery|WorkerWorkerGroupQuery
     */
    public function getWorkerWorkerGroups()
    {
        return $this->hasMany(WorkerWorkerGroup::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[WorkerGroups]].
     *
     * @return ActiveQuery|WorkerGroupQuery
     * @throws InvalidConfigException
     */
    public function getWorkerGroups()
    {
        return $this->hasMany(ApiGroup::class, ['id' => 'worker_group_id'])->viaTable('access_worker_worker_group', ['worker_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return WorkerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkerQuery(get_called_class());
    }
}
