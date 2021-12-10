<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\RuleQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupRuleQuery;
use Smoren\Yii2\AccessManager\structs\Constants;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_user_group_rule".
 *
 * @property string $id
 * @property string $user_group_id
 * @property string $rule_id
 * @property int $created_at
 *
 * @property Rule $rule
 * @property UserGroup $userGroup
 */
class UserGroupRule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::getAlias(Constants::TABLE_PREFIX_ALIAS).'_user_group_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_group_id', 'rule_id'], 'required'],
            [['user_group_id', 'rule_id'], UuidValidator::class],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['user_group_id', 'rule_id'], 'unique', 'targetAttribute' => ['user_group_id', 'rule_id']],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rule::class, 'targetAttribute' => ['rule_id' => 'id']],
            [['user_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserGroup::class, 'targetAttribute' => ['user_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_group_id' => 'User Group ID',
            'rule_id' => 'Rule ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Rule]].
     *
     * @return ActiveQuery|RuleQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rule::class, ['id' => 'rule_id']);
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
     * @return UserGroupRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupRuleQuery(get_called_class());
    }
}
