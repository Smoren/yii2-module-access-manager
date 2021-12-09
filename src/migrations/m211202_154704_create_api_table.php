<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_api`.
 */
class m211202_154704_create_api_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_api', [
            'id' => $this->uuidPrimaryKey(),
            'method' => $this->string(10)->notNull(),
            'path' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex('idx-access_api-created_at', 'access_api', 'created_at');
        $this->createIndex('idx-access_api-method', 'access_api', 'method');
        $this->createIndex('idx-access_api-path', 'access_api', 'path');
        $this->createIndex('idx-access_api-method-path', 'access_api', ['method', 'path'], true);
        $this->createIndex('idx-access_api-title', 'access_api', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access_api');
    }
}
