<?php

namespace Smoren\Yii2\AccessManager\models\query;

use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;

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

}
