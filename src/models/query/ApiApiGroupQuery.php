<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\ApiApiGroup]].
 *
 * @see ApiApiGroup
 */
class ApiApiGroupQuery extends ActiveQuery
{
    /**
     * @param $apiId
     * @param bool $filter
     * @return ApiApiGroupQuery|ActiveQuery
     */
    public function byApi($apiId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('api_id') => $apiId], $filter);
    }

    /**
     * @param $apiGroupId
     * @param bool $filter
     * @return ApiApiGroupQuery|ActiveQuery
     */
    public function byApiGroup($apiGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('api_group_id') => $apiGroupId], $filter);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiApiGroup
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiApiGroup
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiApiGroup[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
