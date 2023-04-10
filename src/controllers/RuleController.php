<?php


namespace Smoren\Yii2\AccessManager\controllers;


use Smoren\Yii2\AccessManager\forms\rule\RuleCreateForm;
use Smoren\Yii2\AccessManager\forms\rule\RuleFilterForm;
use Smoren\Yii2\AccessManager\forms\rule\RuleUpdateForm;
use Smoren\Yii2\AccessManager\models\query\RuleQuery;
use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\AccessManager\traits\AccessControlTrait;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use Smoren\Yii2\Auth\controllers\WorkerTokenController;
use Yii;

class RuleController extends WorkerTokenController
{
    use RestControllerTrait;
    use AccessControlTrait;

    /**
     * @inheritDoc
     * @return RuleCreateForm
     */
    protected function getCreateForm(): Model
    {
        return RuleCreateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return RuleUpdateForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return RuleUpdateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return RuleFilterForm
     */
    protected function getFilterForm(): Model
    {
        return RuleFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param RuleQuery|ActiveQuery $query
     * @param RuleFilterForm $form
     * @return RuleQuery|ActiveQuery
     */
    protected function workerFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
            ->byAlias($form->alias, true)
            ->byTitle($form->title, true);
    }

    /**
     * @inheritDoc
     */
    protected function workerOrder(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query->orderBy(['title' => SORT_ASC]);
    }

    /**
     * @inheritDoc
     */
    protected function getActiveRecordClassName(): string
    {
        return Rule::class;
    }
}
