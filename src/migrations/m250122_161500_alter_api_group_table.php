<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\base\NotSupportedException;


/**
 * Handles the altering of table `{$tablePrefix}_api_group`.
 */
class m250122_161500_alter_api_group_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->addColumn("{$tablePrefix}_api_group", "parent_id", $this->uuid());
        $this->createIndex("idx-{$tablePrefix}_api_group-parent_id", "{$tablePrefix}_api_group", 'parent_id');
        $this->addForeignKey("{$tablePrefix}_api_group-parent_id", "{$tablePrefix}_api_group", 'parent_id', "{$tablePrefix}_api_group", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->dropForeignKey("{$tablePrefix}_api_group-parent_id", "{$tablePrefix}_api_group");
        $this->dropIndex("idx-{$tablePrefix}_api_group-parent_id", "{$tablePrefix}_api_group");
        $this->dropColumn("{$tablePrefix}_api_group", "parent_id");
    }
}
