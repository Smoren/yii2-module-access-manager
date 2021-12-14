<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_rule`.
 */
class m211207_132615_create_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_rule", [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}_rule-created_at", "{$tablePrefix}_rule", 'created_at');
        $this->createIndex("idx-{$tablePrefix}_rule-alias", "{$tablePrefix}_rule", 'alias', true);
        $this->createIndex("idx-{$tablePrefix}_rule-title", "{$tablePrefix}_rule", 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropTable("{$tablePrefix}_rule");
    }
}
