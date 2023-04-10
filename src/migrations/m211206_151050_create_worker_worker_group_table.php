<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_worker_worker_group`.
 */
class m211206_151050_create_worker_worker_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_worker_worker_group", [
            'worker_id' => $this->uuid()->notNull(),
            'worker_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_worker_worker_group-created_at", "{$tablePrefix}_worker_worker_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_worker_worker_group-worker_id", "{$tablePrefix}_worker_worker_group", 'worker_id');
        $this->createIndex("idx-{$tablePrefix}_worker_worker_group-worker_group_id", "{$tablePrefix}_worker_worker_group", 'worker_group_id');
        $this->createIndex("idx-{$tablePrefix}_worker_worker_group-worker_id-worker_group_id", "{$tablePrefix}_worker_worker_group", ['worker_id', 'worker_group_id'], true);
        $this->addPrimaryKey("pk-{$tablePrefix}_worker_worker_group", "{$tablePrefix}_worker_worker_group", ['worker_id', 'worker_group_id']);
        $this->addForeignKey("fk-{$tablePrefix}_worker_worker_group-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_worker_worker_group", 'worker_group_id', "{$tablePrefix}_worker_group", 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_worker_worker_group-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_worker_worker_group");
        $this->dropTable("{$tablePrefix}_worker_worker_group");
    }
}
