<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\ApiGroup]].
 *
 * @see \Smoren\Yii2\AccessManager\models\ApiGroup
 */
class ApiGroupQuery extends \Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery
{
    /**
     * @param $alias
     * @param bool $filter
     * @return ActiveQuery|ApiGroupQuery
     */
    public function byAlias($alias, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('alias') => $alias], $filter);
    }

    /**
     * @param $title
     * @param bool $filter
     * @return ActiveQuery|ApiGroupQuery
     */
    public function byTitle($title, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('title') => $title], $filter);
    }

    /**
     * @param $inMenuFlag
     * @param bool $filter
     * @return ActiveQuery|ApiGroupQuery
     */
    public function byInMenu($inMenuFlag, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('in_menu') => $inMenuFlag], $filter);
    }

    /**
     * @param $inMenuFlag
     * @param bool $filter
     * @return ActiveQuery|ApiGroupQuery
     */
    public function byIsSystem($inMenuFlag, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('is_system') => $inMenuFlag], $filter);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiGroup
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiGroup
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|ApiGroup[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
