<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\PermissionQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\structs\Constants;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_permission".
 *
 * @property string $api_group_id
 * @property string $user_group_id
 * @property int $created_at
 *
 * @property ApiGroup $apiGroup
 * @property UserGroup $userGroup
 */
class Permission extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::getAlias(Constants::TABLE_PREFIX_ALIAS).'_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['api_group_id', 'user_group_id'], UuidValidator::class],
            [['api_group_id', 'user_group_id'], 'required'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['api_group_id', 'user_group_id'], 'unique', 'targetAttribute' => ['api_group_id', 'user_group_id']],
            [['api_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiGroup::class, 'targetAttribute' => ['api_group_id' => 'id']],
            [['user_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserGroup::class, 'targetAttribute' => ['user_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'api_group_id' => 'Api Group ID',
            'user_group_id' => 'User Group ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ApiGroup]].
     *
     * @return ActiveQuery|ApiGroupQuery
     */
    public function getApiGroup()
    {
        return $this->hasOne(ApiGroup::class, ['id' => 'api_group_id']);
    }

    /**
     * Gets query for [[UserGroup]].
     *
     * @return ActiveQuery|UserGroupQuery
     */
    public function getUserGroup()
    {
        return $this->hasOne(UserGroup::class, ['id' => 'user_group_id']);
    }

    /**
     * {@inheritdoc}
     * @return PermissionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermissionQuery(get_called_class());
    }
}
