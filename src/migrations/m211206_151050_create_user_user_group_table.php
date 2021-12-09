<?php

use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the creation of table `access_user_user_group`.
 */
class m211206_151050_create_user_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public function safeUp()
    {
        $this->createTable('access_user_user_group', [
            'user_id' => $this->uuid()->notNull(),
            'user_group_id' => $this->uuid()->notNull(),
            'created_at' => $this->createdAt(),
        ]);
        $this->createIndex('idx-access_user_user_group-created_at', 'access_user_user_group', 'created_at');
        $this->createIndex('idx-access_user_user_group-user_id', 'access_user_user_group', 'user_id');
        $this->createIndex('idx-access_user_user_group-user_group_id', 'access_user_user_group', 'user_group_id');
        $this->createIndex('idx-access_user_user_group-user_id-user_group_id', 'access_user_user_group', ['user_id', 'user_group_id'], true);
        $this->addPrimaryKey('pk-access_user_user_group', 'access_user_user_group', ['user_id', 'user_group_id']);
        $this->addForeignKey('fk-access_user_user_group-user_group_id-access_user_group-id', 'access_user_user_group', 'user_group_id', 'access_user_group', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-access_user_user_group-user_group_id-access_user_group-id', 'access_user_user_group');
        $this->dropTable('access_user_user_group');
    }
}
