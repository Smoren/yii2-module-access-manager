<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_permission`.
 */
class m211206_154048_create_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_permission', [
            'api_group_id' => $this->uuid()->notNull(),
            'user_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex('idx-access_permission-created_at', 'access_permission', 'created_at');
        $this->createIndex('idx-access_permission-api_group_id', 'access_permission', 'api_group_id');
        $this->createIndex('idx-access_permission-user_group_id', 'access_permission', 'user_group_id');
        $this->createIndex('idx-access_permission-api_group_id-user_group_id', 'access_permission', ['api_group_id', 'user_group_id']);
        $this->addPrimaryKey('pk-access_permission', 'access_permission', ['api_group_id', 'user_group_id']);
        $this->addForeignKey('fk-access_permission-api_group_id-access_api_group-id', 'access_permission', 'api_group_id', 'access_api_group', 'id', 'CASCADE');
        $this->addForeignKey('fk-access_permission-user_group_id-access_user_group-id', 'access_permission', 'user_group_id', 'access_user_group', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-access_permission-user_group_id-access_user_group-id', 'access_permission');
        $this->dropForeignKey('fk-access_permission-api_group_id-access_api_group-id', 'access_permission');
        $this->dropTable('access_permission');
    }
}
