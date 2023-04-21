<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

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
     * @return ActiveQuery|ApiQuery
     */
    public function byApiGroup($apiGroupId)
    {
        if (empty($apiGroupId)) {
            return $this;
        }

        $apiIds = Api::find()
            ->alias('a')
            ->innerJoin(['aag' => ApiApiGroup::tableName()], 'aag.api_id = a.id')
            ->innerJoin(['ag' => ApiGroup::tableName()], 'ag.id = aag.api_group_id')
            ->andWhere(['ag.id' => $apiGroupId])
            ->select('a.id')
            ->column();

        return $this->andWhereExtended([$this->aliasColumn('id') => array_unique($apiIds)]);
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

    /**
     * @param Connection|null $db
     * @return array|Api
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Api
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Api[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
