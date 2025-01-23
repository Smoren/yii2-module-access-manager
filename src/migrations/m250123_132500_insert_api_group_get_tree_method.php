<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use thamtech\uuid\helpers\UuidHelper;
use yii\db\Query;

/**
 * Handles the adding of getTree method for ApiGroup.
 */
class m250123_132500_insert_api_group_get_tree_method extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();

        $apiId = UuidHelper::uuid();
        $this->batchInsert(
            "{$tablePrefix}_api",
            ['id', 'method', 'path', 'title'],
            [
                [$apiId, 'get', "/{$tablePrefix}/api-group/tree", 'Get API group tree'],
            ]
        );

        $accessApiGroupId = (new Query())
            ->select('id')
            ->from("{$tablePrefix}_api_group")
            ->andWhere(['alias' => 'access_control'])
            ->column()[0];

        $apiApiGroupsRows = [];

        $apiApiGroupsRows[] = [$apiId, $accessApiGroupId];

        $this->batchInsert(
            "{$tablePrefix}_api_api_group",
            ['api_id', 'api_group_id'],
            $apiApiGroupsRows
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();

        $this->delete("{$tablePrefix}_api", ["path" => "/{$tablePrefix}/api-group/tree"]);
    }
}
