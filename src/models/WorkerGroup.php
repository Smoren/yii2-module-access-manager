<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\PermissionQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerWorkerGroupQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_worker_group".
 *
 * @property string $id
 * @property string $alias
 * @property string $title
 * @property string|null $extra
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property Permission[] $connections
 * @property ApiGroup[] $apiGroups
 * @property WorkerWorkerGroup[] $workerWorkerGroups
 */
class WorkerGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_worker_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], UuidValidator::class],
            [['alias', 'title'], 'required'],
            [['extra'], 'safe'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'alias' => 'Alias',
            'title' => 'Title',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Connections]].
     *
     * @return ActiveQuery|PermissionQuery
     */
    public function getConnections()
    {
        return $this->hasMany(Permission::class, ['worker_group_id' => 'id']);
    }

    /**
     * Gets query for [[ApiGroups]].
     *
     * @return ActiveQuery|ApiGroupQuery
     * @throws InvalidConfigException
     */
    public function getApiGroups()
    {
        return $this->hasMany(ApiGroup::class, ['id' => 'api_group_id'])->viaTable('access_connection', ['worker_group_id' => 'id']);
    }

    /**
     * Gets query for [[WorkerWorkerGroups]].
     *
     * @return ActiveQuery|WorkerWorkerGroupQuery
     */
    public function getWorkerWorkerGroups()
    {
        return $this->hasMany(WorkerWorkerGroup::class, ['worker_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return WorkerGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkerGroupQuery(get_called_class());
    }
}
