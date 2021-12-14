<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_api_api_group`.
 */
class m211206_145808_create_api_api_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_api_api_group", [
            'api_id' => $this->uuid()->notNull(),
            'api_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_api_api_group-created_at", "{$tablePrefix}_api_api_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_api_api_group-api_id", "{$tablePrefix}_api_api_group", 'api_id');
        $this->createIndex("idx-{$tablePrefix}_api_api_group-api_group_id", "{$tablePrefix}_api_api_group", 'api_group_id');
        $this->createIndex("idx-{$tablePrefix}_api_api_group-api_id-api_group_id", "{$tablePrefix}_api_api_group", ['api_id', 'api_group_id'], true);
        $this->addPrimaryKey("pk-{$tablePrefix}_api_api_group", "{$tablePrefix}_api_api_group", ['api_id', 'api_group_id']);
        $this->addForeignKey("fk-{$tablePrefix}_api_api_group-api_id-{$tablePrefix}_api-id", "{$tablePrefix}_api_api_group", 'api_id', '{$tablePrefix}_api', 'id', 'CASCADE');
        $this->addForeignKey("fk-{$tablePrefix}_api_api_group-api_group_id-{$tablePrefix}_api_group-id", "{$tablePrefix}_api_api_group", 'api_group_id', '{$tablePrefix}_api_group', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_api_api_group-api_group_id-{$tablePrefix}_api_group-id", "{$tablePrefix}_api_api_group");
        $this->dropForeignKey("fk-{$tablePrefix}_api_api_group-api_id-{$tablePrefix}_api-id", "{$tablePrefix}_api_api_group");
        $this->dropTable("{$tablePrefix}_api_api_group");
    }
}
