<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\forms\link\WorkerWorkerGroupForm;
use Smoren\Yii2\AccessManager\models\WorkerWorkerGroup;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\helpers\FormValidator;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Yii;

class WorkerWorkerGroupController extends CommonController
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
             * @see WorkerWorkerGroupController::actionLink()
             */
            "POST {$apiPath}" => "{$controllerPath}/link",

            /**
             * @see WorkerWorkerGroupController::actionUnlink()
             */
            "DELETE {$apiPath}" => "{$controllerPath}/unlink",
        ];
    }

    /**
     * @return WorkerWorkerGroup
     * @throws ApiException
     */
    public function actionLink(): WorkerWorkerGroup
    {
        $form = WorkerWorkerGroupForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        $link = new WorkerWorkerGroup();
        $link->worker_id = $form->worker_id;
        $link->worker_group_id = $form->worker_group_id;

        try {
            $link->save();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to save", $e->getCode(), $e);
        }
    }

    /**
     * @return WorkerWorkerGroup
     * @throws ApiException
     */
    public function actionUnlink(): WorkerWorkerGroup
    {
        $form = WorkerWorkerGroupForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        try {
            $link = WorkerWorkerGroup::find()
                ->where(['worker_id' => $form->worker_id, 'worker_group_id' => $form->worker_group_id])
                ->one();
            $link->delete();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to delete", $e->getCode(), $e);
        }
    }
}
