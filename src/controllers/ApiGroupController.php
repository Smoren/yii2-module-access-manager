<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\api_group\ApiGroupCreateForm;
use Smoren\Yii2\AccessManager\forms\api_group\ApiGroupFilterForm;
use Smoren\Yii2\AccessManager\forms\api_group\ApiGroupUpdateForm;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use Yii;

class ApiGroupController extends CommonController
{
    use RestControllerTrait;

    /**
     * @inheritDoc
     * @return ApiGroupCreateForm
     */
    protected function getCreateForm(): Model
    {
        return ApiGroupCreateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return ApiGroupUpdateForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return ApiGroupUpdateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return ApiGroupFilterForm
     */
    protected function getFilterForm(): Model
    {
        return ApiGroupFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param ApiGroupQuery|ActiveQuery $query
     * @param ApiGroupFilterForm $form
     * @return ApiGroupQuery|ActiveQuery
     */
    protected function userFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
            ->byWorkerGroup($form->worker_group_id)
            ->byAlias($form->alias, true)
            ->byTitle($form->title, true)
            ->byInMenu($form->in_menu, true)
            ->byIsSystem($form->is_system, true);
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
        return ApiGroup::class;
    }
}
