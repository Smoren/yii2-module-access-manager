<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_worker_group`.
 */
class m211206_150647_create_worker_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException|\yii\base\Exception
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_worker_group", [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'is_system' => $this->boolean()->notNull()->defaultValue(false),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_worker_group-created_at", "{$tablePrefix}_worker_group", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_worker_group-alias", "{$tablePrefix}_worker_group", 'alias', true);
        $this->createIndex("idx-{$tablePrefix}_worker_group-title", "{$tablePrefix}_worker_group", 'title');
        $this->createIndex("idx-{$tablePrefix}_worker_group-is_system", "{$tablePrefix}_worker_group", 'is_system');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropTable("{$tablePrefix}_worker_group");
    }
}
