<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_user_user_group`.
 */
class m211206_151050_create_user_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_user_user_group", [
            'user_id' => $this->uuid()->notNull(),
            'user_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_user_user_group-created_at", "{$tablePrefix}_user_user_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_user_user_group-user_id", "{$tablePrefix}_user_user_group", 'user_id');
        $this->createIndex("idx-{$tablePrefix}_user_user_group-user_group_id", "{$tablePrefix}_user_user_group", 'user_group_id');
        $this->createIndex("idx-{$tablePrefix}_user_user_group-user_id-user_group_id", "{$tablePrefix}_user_user_group", ['user_id', 'user_group_id'], true);
        $this->addPrimaryKey("pk-{$tablePrefix}_user_user_group", "{$tablePrefix}_user_user_group", ['user_id', 'user_group_id']);
        $this->addForeignKey("fk-{$tablePrefix}_user_user_group-user_group_id-{$tablePrefix}_user_group-id", "{$tablePrefix}_user_user_group", 'user_group_id', "{$tablePrefix}_user_group", 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("fk-{$tablePrefix}_user_user_group-user_group_id-{$tablePrefix}_user_group-id", "{$tablePrefix}_user_user_group");
        $this->dropTable("{$tablePrefix}_user_user_group");
    }
}
