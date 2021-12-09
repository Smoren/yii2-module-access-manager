<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_user_group`.
 */
class m211206_150647_create_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException|\yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable('access_user_group', [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex('idx-access_user_group-created_at', 'access_user_group', 'created_at');
        $this->createIndex('idx-access_user_group-alias', 'access_user_group', 'alias', true);
        $this->createIndex('idx-access_user_group-title', 'access_user_group', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access_user_group');
    }
}
