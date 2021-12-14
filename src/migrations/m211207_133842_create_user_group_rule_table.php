<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_user_group_rule`.
 */
class m211207_133842_create_user_group_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_user_group_rule", [
            'user_group_id' => $this->uuid()->notNull(),
            'rule_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_user_group_rule-created_at", "{$tablePrefix}_user_group_rule", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_user_group_rule-user_group_id", "{$tablePrefix}_user_group_rule", 'user_group_id');
        $this->createIndex("idx-{$tablePrefix}_user_group_rule-rule_id", "{$tablePrefix}_user_group_rule", 'rule_id');
        $this->createIndex("idx-{$tablePrefix}_user_group_rule-user_group_id-rule_id", "{$tablePrefix}_user_group_rule", ['user_group_id', 'rule_id'], true);
        $this->addPrimaryKey("pk-{$tablePrefix}_user_group_rule", "{$tablePrefix}_user_group_rule", ['user_group_id', 'rule_id']);
        $this->addForeignKey("fk-{$tablePrefix}_user_group_rule-user_group_id-{$tablePrefix}_user_group-id", "{$tablePrefix}_user_group_rule", 'user_group_id', "{$tablePrefix}_user_group", 'id', 'CASCADE');
        $this->addForeignKey("fk-{$tablePrefix}_user_group_rule-rule_id-{$tablePrefix}_rule-id", "{$tablePrefix}_user_group_rule", 'rule_id', "{$tablePrefix}_rule", 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_user_group_rule-user_group_id-{$tablePrefix}_user_group-id", "{$tablePrefix}_user_group_rule");
        $this->dropForeignKey("fk-{$tablePrefix}_user_group_rule-rule_id-{$tablePrefix}_rule-id", "{$tablePrefix}_user_group_rule");
        $this->dropTable("{$tablePrefix}_user_group_rule");
    }
}
