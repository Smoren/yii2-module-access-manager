<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\ApiApiGroup]].
 *
 * @see \Smoren\Yii2\AccessManager\models\ApiApiGroup
 */
class ApiApiGroupQuery extends \Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery
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
}
