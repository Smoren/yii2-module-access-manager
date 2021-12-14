<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_api_group`.
 */
class m211202_155654_create_api_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \Smoren\ExtendedExceptions\LogicException
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_api_group", [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'in_menu' => $this->boolean()->notNull()->defaultValue(false),
            'is_system' => $this->boolean()->notNull()->defaultValue(false),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_api_group-created_at", "{$tablePrefix}_api_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_api_group-alias", "{$tablePrefix}_api_group", 'alias', true);
        $this->createIndex("idx-{$tablePrefix}_api_group-in_menu", "{$tablePrefix}_api_group", 'in_menu');
        $this->createIndex("idx-{$tablePrefix}_api_group-is_system", "{$tablePrefix}_api_group", 'is_system');
    }

    /**
     * {@inheritdoc}
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropTable("{$tablePrefix}_api_group");
    }
}
