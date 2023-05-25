<?php

namespace Smoren\Yii2\AccessManager\controllers;

use Smoren\Yii2\AccessManager\models\WorkerGroupRule;
use Smoren\Yii2\AccessManager\forms\link\WorkerGroupRuleForm;
use Smoren\Yii2\ActiveRecordExplicit\exceptions\DbException;
use Smoren\Yii2\ActiveRecordExplicit\helpers\FormValidator;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Yii;

class WorkerGroupRuleController extends CommonController
{
    /**
     * @param string $apiPath
     * @param string $controllerPath
     * @return array
     */
    public static function getRules(string $apiPath, string $controllerPath): array
    {
        return [
            /**
             * @see WorkerGroupRuleController::actionLink()
             */
            "POST {$apiPath}" => "{$controllerPath}/link",

            /**
             * @see WorkerGroupRuleController::actionUnlink()
             */
            "DELETE {$apiPath}" => "{$controllerPath}/unlink",
        ];
    }

    /**
     * @return WorkerGroupRule
     * @throws ApiException
     */
    public function actionLink(): WorkerGroupRule
    {
        $form = WorkerGroupRuleForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        $link = new WorkerGroupRule();
        $link->worker_group_id = $form->worker_group_id;
        $link->rule_id = $form->rule_id;

        try {
            $link->save();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to save", $e->getCode(), $e);
        }
    }

    /**
     * @return WorkerGroupRule
     * @throws ApiException
     */
    public function actionUnlink(): WorkerGroupRule
    {
        $form = WorkerGroupRuleForm::create(Yii::$app->request->bodyParams);
        FormValidator::validate($form, ApiException::class);

        try {
            $link = WorkerGroupRule::find()
                ->where(['worker_group_id' => $form->worker_group_id, 'rule_id' => $form->rule_id])
                ->one();
            $link->delete();
            return $link;
        } catch (DbException $e) {
            throw new ApiException("Failed to delete", $e->getCode(), $e);
        }
    }
}
