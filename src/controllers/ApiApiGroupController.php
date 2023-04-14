<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\link\ApiApiGroupForm;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\helpers\FormValidator;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Yii;

class ApiApiGroupController extends CommonController
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
             * @see ApiApiGroupController::actionLink()
             */
            "POST {$apiPath}" => "{$controllerPath}/link",

            /**
             * @see ApiApiGroupController::actionUnlink()
             */
            "DELETE {$apiPath}" => "{$controllerPath}/unlink",
        ];
    }

    /**
     * @return ApiApiGroup
     * @throws ApiException
     */
    public function actionLink(): ApiApiGroup
    {
        $form = ApiApiGroupForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        $link = new ApiApiGroup();
        $link->api_id = $form->api_id;
        $link->api_group_id = $form->api_group_id;

        try {
            $link->save();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to save", $e->getCode(), $e);
        }
    }

    /**
     * @return ApiApiGroup
     * @throws ApiException
     */
    public function actionUnlink(): ApiApiGroup
    {
        $form = ApiApiGroupForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        try {
            $link = ApiApiGroup::find()
                ->where(['api_id' => $form->api_id, 'api_group_id' => $form->api_group_id])
                ->one();
            $link->delete();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to delete", $e->getCode(), $e);
        }
    }
}
