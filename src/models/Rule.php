<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\RuleQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupRuleQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_rule".
 *
 * @property string $id
 * @property string $alias
 * @property string $title
 * @property bool $is_system
 * @property int $sort
 * @property string|null $extra
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property WorkerGroupRule[] $accessWorkerGroupRules
 * @property WorkerGroup[] $workerGroups
 */
class Rule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', UuidValidator::class],
            [['alias', 'title'], 'required'],
            [['is_system'], 'boolean'],
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
            'alias' => 'Alias',
            'title' => 'Title',
            'is_system' => 'Is System',
            'sort' => 'Sort',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AccessWorkerGroupRules]].
     *
     * @return ActiveQuery|WorkerGroupRuleQuery
     */
    public function getAccessWorkerGroupRules()
    {
        return $this->hasMany(WorkerGroupRule::class, ['rule_id' => 'id']);
    }

    /**
     * Gets query for [[WorkerGroups]].
     *
     * @return ActiveQuery|WorkerGroupQuery
     * @throws InvalidConfigException
     */
    public function getWorkerGroups()
    {
        return $this->hasMany(WorkerGroup::class, ['id' => 'worker_group_id'])
            ->viaTable('access_worker_group_rule', ['rule_id' => 'id']);
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
