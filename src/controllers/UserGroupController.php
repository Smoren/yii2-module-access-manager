<?php


namespace Smoren\Yii2\AccessManager\controllers;


use Smoren\Yii2\AccessManager\forms\user_group\UserGroupCreateForm;
use Smoren\Yii2\AccessManager\forms\user_group\UserGroupFilterForm;
use Smoren\Yii2\AccessManager\forms\user_group\UserGroupUpdateForm;
use Smoren\Yii2\AccessManager\models\query\UserGroupQuery;
use Smoren\Yii2\AccessManager\models\UserGroup;
use Smoren\Yii2\AccessManager\traits\AccessControlTrait;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\Model;
use Smoren\Yii2\Auth\controllers\RestControllerTrait;
use Smoren\Yii2\Auth\controllers\UserTokenController;
use Yii;

class UserGroupController extends UserTokenController
{
    use RestControllerTrait;
    use AccessControlTrait;

    /**
     * @inheritDoc
     * @return UserGroupCreateForm
     */
    protected function getCreateForm(): Model
    {
        return UserGroupCreateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return UserGroupUpdateForm
     */
    protected function getUpdateForm(string $itemId, $item): Model
    {
        return UserGroupUpdateForm::create(Yii::$app->request->bodyParams);
    }

    /**
     * @inheritDoc
     * @return UserGroupFilterForm
     */
    protected function getFilterForm(): Model
    {
        return UserGroupFilterForm::create(Yii::$app->request->queryParams);
    }

    /**
     * @inheritDoc
     * @param UserGroupQuery|ActiveQuery $query
     * @param UserGroupFilterForm $form
     * @return UserGroupQuery|ActiveQuery
     */
    protected function userFilter(ActiveQuery $query, ?Model $form): ActiveQuery
    {
        return $query
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
        return UserGroup::class;
    }
}
