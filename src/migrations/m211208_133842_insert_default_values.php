<?php

use Smoren\Yii2\AccessManager\Module;
use Smoren\Yii2\ActiveRecordExplicit\models\Migration;
use yii\db\Query;

/**
 * Handles the creation of table `{$tablePrefix}_worker_group_rule`.
 */
class m211208_133842_insert_default_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tablePrefix = Module::getDbTablePrefix();
        $this->batchInsert(
            "{$tablePrefix}_api",
            ['method', 'path', 'title'],
            [
                ['get', "/{$tablePrefix}/api", 'Get API list'],
                ['post', "/{$tablePrefix}/api", 'Create API item'],
                ['get', "/{$tablePrefix}/api/{id}", 'Get API item'],
                ['put', "/{$tablePrefix}/api/{id}", 'Update API item'],
                ['delete', "/{$tablePrefix}/api/{id}", 'Delete API item'],

                ['get', "/{$tablePrefix}/api-group", 'Get API group list'],
                ['post', "/{$tablePrefix}/api-group", 'Create API group item'],
                ['get', "/{$tablePrefix}/api-group/{id}", 'Get API group item'],
                ['put', "/{$tablePrefix}/api-group/{id}", 'Update API group item'],
                ['delete', "/{$tablePrefix}/api-group/{id}", 'Delete API group item'],

                ['get', "/{$tablePrefix}/worker-group", 'Get Worker group list'],
                ['post', "/{$tablePrefix}/worker-group", 'Create Worker group item'],
                ['get', "/{$tablePrefix}/worker-group/{id}", 'Get Worker group item'],
                ['put', "/{$tablePrefix}/worker-group/{id}", 'Update Worker group item'],
                ['delete', "/{$tablePrefix}/worker-group/{id}", 'Delete Worker group item'],

                ['get', "/{$tablePrefix}/rule", 'Get Rule list'],
                ['post', "/{$tablePrefix}/rule", 'Create Rule item'],
                ['get', "/{$tablePrefix}/rule/{id}", 'Get Rule item'],
                ['put', "/{$tablePrefix}/rule/{id}", 'Update Rule item'],
                ['delete', "/{$tablePrefix}/rule/{id}", 'Delete Rule item'],
            ]
        );

        $apiIds = (new Query())
            ->select('id')
            ->from("{$tablePrefix}_api")
            ->column();

        $this->insert(
            "{$tablePrefix}_api_group",
            [
                'alias' => 'access_control',
                'title' => 'Access control',
                'in_menu' => false,
                'is_system' => true,
            ]
        );

        $apiGroupId = (new Query())
            ->select('id')
            ->from("{$tablePrefix}_api_group")
            ->andWhere(['alias' => 'access_control'])
            ->column()[0];

        $apiApiGroupsRows = [];

        foreach ($apiIds as $apiId) {
            $apiApiGroupsRows[] = [$apiId, $apiGroupId];
        }

        $this->batchInsert(
            "{$tablePrefix}_api_api_group",
            ['api_id', 'api_group_id'],
            $apiApiGroupsRows
        );

        $this->insert(
            "{$tablePrefix}_worker_group",
            [
                'alias' => 'admin',
                'title' => 'Administrators',
            ]
        );

        $workerGroupId = (new Query())
            ->select('id')
            ->from("{$tablePrefix}_worker_group")
            ->andWhere(['alias' => 'admin'])
            ->column()[0];

        $this->insert(
            "{$tablePrefix}_permission",
            [
                'api_group_id' => $apiGroupId,
                'worker_group_id' => $workerGroupId,
            ]
        );

        $this->insert(
            "{$tablePrefix}_rule",
            [
                'alias' => 'is_admin',
                'title' => 'Is admin',
            ]
        );

        $ruleId = (new Query())
            ->select('id')
            ->from("{$tablePrefix}_rule")
            ->andWhere(['alias' => 'is_admin'])
            ->column()[0];

        $this->insert(
            "{$tablePrefix}_worker_group_rule",
            [
                'worker_group_id' => $workerGroupId,
                'rule_id' => $ruleId,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tablePrefix = Module::getDbTablePrefix();

        $this->delete("{$tablePrefix}_api");
        $this->delete("{$tablePrefix}_api_group");
        $this->delete("{$tablePrefix}_worker_group");
        $this->delete("{$tablePrefix}_rule");
    }
}
