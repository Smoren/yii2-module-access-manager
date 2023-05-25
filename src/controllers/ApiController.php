<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\api\ApiCreateForm;
use Smoren\Yii2\AccessManager\forms\api\ApiFilterForm;
use Smoren\Yii2\AccessManager\forms\api\ApiUpdateForm;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\query\ApiQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Yii;

class ApiController extends CommonRestController
{
    /**
     * @inheritDoc
     * @return ApiCreateForm
     */
    protected function getCreateForm(): Model
    {
        return ApiCreateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return ApiUpdateForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return ApiUpdateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return ApiFilterForm
     */
    protected function getFilterForm(): Model
    {
        return ApiFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param ApiQuery|ActiveQuery $query
     * @param ApiFilterForm $form
     * @return ApiQuery|ActiveQuery
     */
    protected function userFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
            ->byApiGroup($form->api_group_id)
            ->byMethod($form->method, true)
            ->byPath($form->path, true)
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
        return Api::class;
    }
}
