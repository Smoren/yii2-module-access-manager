<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_api_group`.
 */
class m211202_155654_create_api_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_api_group', [
            'id' => $this->uuidPrimaryKey(),
            'alias' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'in_menu' => $this->boolean()->notNull()->defaultValue(false),
            'is_system' => $this->boolean()->notNull()->defaultValue(false),
            'extra' => $this->json(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ]);
        $this->createIndex('idx-access_api_group-created_at', 'access_api_group', 'created_at');
        $this->createIndex('idx-access_api_group-alias', 'access_api_group', 'alias', true);
        $this->createIndex('idx-access_api_group-in_menu', 'access_api_group', 'in_menu');
        $this->createIndex('idx-access_api_group-is_system', 'access_api_group', 'is_system');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access_api_group');
    }
}
