<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_api_api_group`.
 */
class m211206_145808_create_api_api_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_api_api_group', [
            'api_id' => $this->uuid()->notNull(),
            'api_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex('idx-access_api_api_group-created_at', 'access_api_api_group', 'created_at');
        $this->createIndex('idx-access_api_api_group-api_id', 'access_api_api_group', 'api_id');
        $this->createIndex('idx-access_api_api_group-api_group_id', 'access_api_api_group', 'api_group_id');
        $this->createIndex('idx-access_api_api_group-api_id-api_group_id', 'access_api_api_group', ['api_id', 'api_group_id'], true);
        $this->addPrimaryKey('pk-access_api_api_group', 'access_api_api_group', ['api_id', 'api_group_id']);
        $this->addForeignKey('fk-access_api_api_group-api_id-access_api-id', 'access_api_api_group', 'api_id', 'access_api', 'id', 'CASCADE');
        $this->addForeignKey('fk-access_api_api_group-api_group_id-access_api_group-id', 'access_api_api_group', 'api_group_id', 'access_api_group', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-access_api_api_group-api_group_id-access_api_group-id', 'access_api_api_group');
        $this->dropForeignKey('fk-access_api_api_group-api_id-access_api-id', 'access_api_api_group');
        $this->dropTable('access_api_api_group');
    }
}
