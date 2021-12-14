<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_user_group`.
 */
class m211206_150647_create_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException|\yii\base\Exception
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_user_group", [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_user_group-created_at", "{$tablePrefix}_user_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_user_group-alias", "{$tablePrefix}_user_group", 'alias', true);
        $this->createIndex("idx-{$tablePrefix}_user_group-title", "{$tablePrefix}_user_group", 'title');
    }

    /**
     * {@inheritdoc}
     * @throws \Smoren\ExtendedExceptions\LogicException
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropTable("{$tablePrefix}_user_group");
    }
}
