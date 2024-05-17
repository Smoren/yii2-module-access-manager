<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\Smoren\Yii2\AccessManager\models\Rule]].
 *
 * @see \Smoren\Yii2\AccessManager\models\Rule
 */
class RuleQuery extends ActiveQuery
{
    /**
     * @param $alias
     * @param bool $filter
     * @return ActiveQuery|RuleQuery
     */
    public function byAlias($alias, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('alias') => $alias], $filter);
    }

    /**
     * @param $title
     * @param bool $filter
     * @return ActiveQuery|RuleQuery
     */
    public function byTitle($title, bool $filter = false)
    {
        return $this->andWhereExtended([$this->aliasColumn('title') => $title], $filter);
    }

    /**
     * @param int $direction
     * @return self
     */
    public function sort(int $direction = SORT_ASC): self
    {
        return $this->orderBy(['sort' => $direction]);
    }

    /**
     * @param Connection|null $db
     * @return array|Rule
     * @throws DbException
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Rule
     * @throws DbException
     */
    public function first($db = null)
    {
        return parent::first($db);
    }

    /**
     * @param Connection|null $db
     * @return array|Rule[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }
}
