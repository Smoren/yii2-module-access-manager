<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\RuleQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\models\query\UserGroupRuleQuery;
use Smoren\Yii2\AccessManager\structs\Constants;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_rule".
 *
 * @property string $id
 * @property string $alias
 * @property string $title
 * @property string|null $extra
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property UserGroupRule[] $accessUserGroupRules
 * @property UserGroup[] $userGroups
 */
class Rule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::getAlias(Constants::TABLE_PREFIX_ALIAS).'_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', UuidValidator::class],
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
     * Gets query for [[AccessUserGroupRules]].
     *
     * @return ActiveQuery|UserGroupRuleQuery
     */
    public function getAccessUserGroupRules()
    {
        return $this->hasMany(UserGroupRule::class, ['rule_id' => 'id']);
    }

    /**
     * Gets query for [[UserGroups]].
     *
     * @return ActiveQuery|UserGroupQuery
     * @throws InvalidConfigException
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroup::class, ['id' => 'user_group_id'])
            ->viaTable('access_user_group_rule', ['rule_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RuleQuery(get_called_class());
    }
}
