<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_rule`.
 */
class m211207_132615_create_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_rule', [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex('idx-access_rule-created_at', 'access_rule', 'created_at');
        $this->createIndex('idx-access_rule-alias', 'access_rule', 'alias', true);
        $this->createIndex('idx-access_rule-title', 'access_rule', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access_rule');
    }
}
