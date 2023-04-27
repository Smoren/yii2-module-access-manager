<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\worker\WorkerFilterForm;
use Smoren\Yii2\AccessManager\models\query\WorkerQuery;
use Smoren\Yii2\AccessManager\models\Worker;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use Yii;

class WorkerController extends CommonController
{
    use RestControllerTrait;

    /**
     * @param string $apiPath
     * @param string $controllerPath
     * @param string $itemIdValidationRegexp
     * @return array
     */
    public static function getRules(string $apiPath, string $controllerPath, string $itemIdValidationRegexp): array
    {
        return [

            /**
             * API for getting collection
             * @see RestControllerTrait::actionCollection()
             */
            "GET {$apiPath}" => "{$controllerPath}/collection",

        ];
    }

    /**
     * @inheritDoc
     * @return WorkerFilterForm
     */
    protected function getCreateForm(): Model
    {
        return WorkerFilterForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return WorkerFilterForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return WorkerFilterForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return WorkerFilterForm
     */
    protected function getFilterForm(): Model
    {
        return WorkerFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param WorkerQuery|ActiveQuery $query
     * @param WorkerFilterForm $form
     * @return WorkerQuery|ActiveQuery
     */
    protected function userFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
            ->byWorkerGroup($form->worker_group_id)
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
        return Worker::class;
    }
}
