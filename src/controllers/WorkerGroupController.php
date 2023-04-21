<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\worker_group\WorkerGroupCreateForm;
use Smoren\Yii2\AccessManager\forms\worker_group\WorkerGroupFilterForm;
use Smoren\Yii2\AccessManager\forms\worker_group\WorkerGroupUpdateForm;
use Smoren\Yii2\AccessManager\models\query\WorkerGroupQuery;
use Smoren\Yii2\AccessManager\models\WorkerGroup;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use Yii;

class WorkerGroupController extends CommonController
{
    use RestControllerTrait;

    /**
     * @inheritDoc
     * @return WorkerGroupCreateForm
     */
    protected function getCreateForm(): Model
    {
        return WorkerGroupCreateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return WorkerGroupUpdateForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return WorkerGroupUpdateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return WorkerGroupFilterForm
     */
    protected function getFilterForm(): Model
    {
        return WorkerGroupFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param WorkerGroupQuery|ActiveQuery $query
     * @param WorkerGroupFilterForm $form
     * @return WorkerGroupQuery|ActiveQuery
     */
    protected function userFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
            ->byWorker($form->worker_id)
            ->byAlias($form->alias, true)
            ->byTitle($form->title, true);
    }

    /**
     * @inheritDoc
     */
    protected function userOrder(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query->orderBy(['title' => SORT_ASC]);
    }

    /**
     * @inheritDoc
     */
    protected function getActiveRecordClassName(): string
    {
        return WorkerGroup::class;
    }
}
