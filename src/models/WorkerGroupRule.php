<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\RuleQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupRuleQuery;
use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_worker_group_rule".
 *
 * @property string $id
 * @property string $worker_group_id
 * @property string $rule_id
 * @property int $created_at
 *
 * @property Rule $rule
 * @property WorkerGroup $workerGroup
 */
class WorkerGroupRule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Module::getDbTablePrefix().'_worker_group_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['worker_group_id', 'rule_id'], 'required'],
            [['worker_group_id', 'rule_id'], UuidValidator::class],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['worker_group_id', 'rule_id'], 'unique', 'targetAttribute' => ['worker_group_id', 'rule_id']],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rule::class, 'targetAttribute' => ['rule_id' => 'id']],
            [['worker_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkerGroup::class, 'targetAttribute' => ['worker_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'worker_group_id' => 'Worker Group ID',
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
     * @return WorkerGroupRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkerGroupRuleQuery(get_called_class());
    }
}
