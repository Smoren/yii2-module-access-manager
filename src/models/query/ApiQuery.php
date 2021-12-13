<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\Api]].
 *
 * @see \Smoren\Yii2\AccessManager\models\Api
 */
class ApiQuery extends ActiveQuery
{
    /**
     * @param $title
     * @param bool $filter
     * @return ActiveQuery|ApiQuery
     */
    public function byTitle($title, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('title') => $title], $filter);
    }

    /**
     * @param $apiGroupId
     * @param bool $filter
     * @return ActiveQuery|ApiQuery
     */
    public function byApiGroup($apiGroupId, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('api_group_id') => $apiGroupId], $filter);
    }

    /**
     * @param $method
     * @param bool $filter
     * @return ActiveQuery|ApiQuery
     */
    public function byMethod($method, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('method') => $method], $filter);
    }

    /**
     * @param $path
     * @param bool $filter
     * @return ActiveQuery|ApiQuery
     */
    public function byPath($path, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('path') => $path], $filter);
    }
}
