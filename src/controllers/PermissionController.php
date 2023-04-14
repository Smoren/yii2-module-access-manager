<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\link\PermissionForm;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\helpers\FormValidator;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Yii;

class PermissionController extends CommonController
{
    /**
     * @param string $apiPath
     * @param string $controllerPath
     * @param string $uuidRegexp
     * @return array
     */
    public static function getRules(string $apiPath, string $controllerPath): array
    {
        return [
            /**
             * @see PermissionController::actionLink()
             */
            "POST {$apiPath}" => "{$controllerPath}/link",

            /**
             * @see PermissionController::actionUnlink()
             */
            "DELETE {$apiPath}" => "{$controllerPath}/unlink",
        ];
    }

    /**
     * @return Permission
     * @throws ApiException
     */
    public function actionLink(): Permission
    {
        $form = PermissionForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        $link = new Permission();
        $link->api_group_id = $form->api_group_id;
        $link->worker_group_id = $form->worker_group_id;

        try {
            $link->save();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to save", $e->getCode(), $e);
        }
    }

    /**
     * @return Permission
     * @throws ApiException
     */
    public function actionUnlink(): Permission
    {
        $form = PermissionForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        try {
            $link = Permission::find()
                ->where(['api_group_id' => $form->api_group_id, 'worker_group_id' => $form->worker_group_id])
                ->one();
            $link->delete();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to delete", $e->getCode(), $e);
        }
    }
}
