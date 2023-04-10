<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;

/**
 * Handles the creation of table `{$tablePrefix}_worker_group_rule`.
 */
class m211207_133842_create_worker_group_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_worker_group_rule", [
            'worker_group_id' => $this->uuid()->notNull(),
            'rule_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_worker_group_rule-created_at", "{$tablePrefix}_worker_group_rule", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_worker_group_rule-worker_group_id", "{$tablePrefix}_worker_group_rule", 'worker_group_id');
        $this->createIndex("idx-{$tablePrefix}_worker_group_rule-rule_id", "{$tablePrefix}_worker_group_rule", 'rule_id');
        $this->createIndex("idx-{$tablePrefix}_worker_group_rule-worker_group_id-rule_id", "{$tablePrefix}_worker_group_rule", ['worker_group_id', 'rule_id'], true);
        $this->addPrimaryKey("pk-{$tablePrefix}_worker_group_rule", "{$tablePrefix}_worker_group_rule", ['worker_group_id', 'rule_id']);
        $this->addForeignKey("fk-{$tablePrefix}_worker_group_rule-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_worker_group_rule", 'worker_group_id', "{$tablePrefix}_worker_group", 'id', 'CASCADE');
        $this->addForeignKey("fk-{$tablePrefix}_worker_group_rule-rule_id-{$tablePrefix}_rule-id", "{$tablePrefix}_worker_group_rule", 'rule_id', "{$tablePrefix}_rule", 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_worker_group_rule-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_worker_group_rule");
        $this->dropForeignKey("fk-{$tablePrefix}_worker_group_rule-rule_id-{$tablePrefix}_rule-id", "{$tablePrefix}_worker_group_rule");
        $this->dropTable("{$tablePrefix}_worker_group_rule");
    }
}
