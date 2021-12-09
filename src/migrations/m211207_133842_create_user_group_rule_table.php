<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_user_group_rule`.
 */
class m211207_133842_create_user_group_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_user_group_rule', [
            'user_group_id' => $this->uuid()->notNull(),
            'rule_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex('idx-access_user_group_rule-created_at', 'access_user_group_rule', 'created_at');
        $this->createIndex('idx-access_user_group_rule-user_group_id', 'access_user_group_rule', 'user_group_id');
        $this->createIndex('idx-access_user_group_rule-rule_id', 'access_user_group_rule', 'rule_id');
        $this->createIndex('idx-access_user_group_rule-user_group_id-rule_id', 'access_user_group_rule', ['user_group_id', 'rule_id'], true);
        $this->addPrimaryKey('pk-access_user_group_rule', 'access_user_group_rule', ['user_group_id', 'rule_id']);
        $this->addForeignKey('fk-access_user_group_rule-user_group_id-access_user_group-id', 'access_user_group_rule', 'user_group_id', 'access_user_group', 'id', 'CASCADE');
        $this->addForeignKey('fk-access_user_group_rule-rule_id-access_rule-id', 'access_user_group_rule', 'rule_id', 'access_rule', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-access_user_group_rule-user_group_id-access_user_group-id', 'access_user_group_rule');
        $this->dropForeignKey('fk-access_user_group_rule-rule_id-access_rule-id', 'access_user_group_rule');
        $this->dropTable('access_user_group_rule');
    }
}
