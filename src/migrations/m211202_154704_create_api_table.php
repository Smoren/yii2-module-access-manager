<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `{$tablePrefix}_api`.
 */
class m211202_154704_create_api_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->createTable("{$tablePrefix}_api", [
            'id' => $this->uuidPrimaryKey(),
            'method' => $this->string(10)->notNull(),
            'path' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex("idx-{$tablePrefix}-created_at", "{$tablePrefix}_api", 'created_at');
        $this->createIndex("idx-{$tablePrefix}-method", "{$tablePrefix}_api", 'method');
        $this->createIndex("idx-{$tablePrefix}-path", "{$tablePrefix}_api", 'path');
        $this->createIndex("idx-{$tablePrefix}-method-path", "{$tablePrefix}_api", ['method', 'path'], true);
        $this->createIndex("idx-{$tablePrefix}-title", "{$tablePrefix}_api", 'title');
        $this->createIndex("idx-{$tablePrefix}-sort", "{$tablePrefix}_api", 'sort');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropTable("{$tablePrefix}_api");
    }
}
