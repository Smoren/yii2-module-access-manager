<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\models\query\UserUserGroupQuery;
use Smoren\Yii2\AccessManager\structs\Constants;
use Smoren\Yii2\AccessManager\validators\PolytypicIdValidator;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_user_user_group".
 *
 * @property string $user_id
 * @property string $user_group_id
 * @property int $created_at
 *
 * @property UserGroup $userGroup
 */
class UserUserGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::getAlias(Constants::TABLE_PREFIX_ALIAS).'_user_user_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_group_id'], PolytypicIdValidator::class],
            [['user_id', 'user_group_id'], 'required'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['user_id', 'user_group_id'], 'unique', 'targetAttribute' => ['user_id', 'user_group_id']],
            [['user_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserGroup::class, 'targetAttribute' => ['user_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_group_id' => 'User Group ID',
            'created_at' => 'Created At',
        ];
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
     * @return UserUserGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserUserGroupQuery(get_called_class());
    }
}
