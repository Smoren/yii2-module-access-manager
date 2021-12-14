<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\ExtendedExceptions\LogicException;
use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\PermissionQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\models\query\UserUserGroupQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_user_group".
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
 * @property UserUserGroup[] $userUserGroups
 */
class UserGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     * @throws LogicException
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_user_group';
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
        return $this->hasMany(Permission::class, ['user_group_id' => 'id']);
    }

    /**
     * Gets query for [[ApiGroups]].
     *
     * @return ActiveQuery|ApiGroupQuery
     * @throws InvalidConfigException
     */
    public function getApiGroups()
    {
        return $this->hasMany(ApiGroup::class, ['id' => 'api_group_id'])->viaTable('access_connection', ['user_group_id' => 'id']);
    }

    /**
     * Gets query for [[UserUserGroups]].
     *
     * @return ActiveQuery|UserUserGroupQuery
     */
    public function getUserUserGroups()
    {
        return $this->hasMany(UserUserGroup::class, ['user_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupQuery(get_called_class());
    }
}
