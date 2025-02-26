<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\ApiApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiQuery;
use Smoren\Yii2\AccessManager\models\query\PermissionQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_api_group".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $alias
 * @property string $title
 * @property bool $in_menu
 * @property bool $is_system
 * @property bool $is_secured
 * @property int $sort
 * @property string|null $extra
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property ApiGroup $apiGroup
 * @property ApiApiGroup[] $apiApiGroups
 * @property Api[] $apis
 * @property Permission[] $connections
 * @property WorkerGroup[] $workerGroups
 */
class ApiGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_api_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], UuidValidator::class],
            [['alias', 'title'], 'required'],
            [['in_menu', 'is_system', 'is_secured'], 'boolean'],
            [['extra'], 'safe'],
            [['sort'], 'default', 'value' => 0],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['sort', 'created_at', 'updated_at'], 'integer'],
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
            'parent_id' => 'Parent ID',
            'alias' => 'Alias',
            'title' => 'Title',
            'in_menu' => 'In Menu',
            'is_system' => 'Is System',
            'is_secured' => 'Is Secured',
            'sort' => 'Sort',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ApiGroup]].
     *
     * @return ActiveQuery|ApiGroupQuery
     */
    public function getApiGroups()
    {
        return $this->hasOne(ApiGroup::class, ['api_group_id' => 'id']);
    }

    /**
     * Gets query for [[ApiApiGroups]].
     *
     * @return ActiveQuery|ApiApiGroupQuery
     */
    public function getApiApiGroups()
    {
        return $this->hasMany(ApiApiGroup::class, ['api_group_id' => 'id']);
    }

    /**
     * Gets query for [[Apis]].
     *
     * @return ActiveQuery|ApiQuery
     * @throws InvalidConfigException
     */
    public function getApis()
    {
        return $this->hasMany(Api::class, ['id' => 'api_id'])->viaTable('access_api_api_group', ['api_group_id' => 'id']);
    }

    /**
     * Gets query for [[Connections]].
     *
     * @return ActiveQuery|PermissionQuery
     */
    public function getConnections()
    {
        return $this->hasMany(Permission::class, ['api_group_id' => 'id']);
    }

    /**
     * Gets query for [[WorkerGroups]].
     *
     * @return ActiveQuery|WorkerGroupQuery
     * @throws InvalidConfigException
     */
    public function getWorkerGroups()
    {
        return $this->hasMany(WorkerGroup::class, ['id' => 'worker_group_id'])->viaTable('access_connection', ['api_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiGroupQuery(get_called_class());
    }
}
