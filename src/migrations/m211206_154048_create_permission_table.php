<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_permission`.
 */
class m211206_154048_create_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_permission", [
            'api_group_id' => $this->uuid()->notNull(),
            'worker_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_permission-created_at", "{$tablePrefix}_permission", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_permission-api_group_id", "{$tablePrefix}_permission", 'api_group_id');
        $this->createIndex("idx-{$tablePrefix}_permission-worker_group_id", "{$tablePrefix}_permission", 'worker_group_id');
        $this->createIndex("idx-{$tablePrefix}_permission-api_group_id-worker_group_id", "{$tablePrefix}_permission", ['api_group_id', 'worker_group_id']);
        $this->addPrimaryKey("pk-{$tablePrefix}_permission", "{$tablePrefix}_permission", ['api_group_id', 'worker_group_id']);
        $this->addForeignKey("fk-{$tablePrefix}_permission-api_group_id-{$tablePrefix}_api_group-id", "{$tablePrefix}_permission", 'api_group_id', "{$tablePrefix}_api_group", 'id', 'CASCADE');
        $this->addForeignKey("fk-{$tablePrefix}_permission-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_permission", 'worker_group_id', "{$tablePrefix}_worker_group", 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_permission-worker_group_id-{$tablePrefix}_worker_group-id", "{$tablePrefix}_permission");
        $this->dropForeignKey("fk-{$tablePrefix}_permission-api_group_id-{$tablePrefix}_api_group-id", "{$tablePrefix}_permission");
        $this->dropTable("{$tablePrefix}_permission");
    }
}
