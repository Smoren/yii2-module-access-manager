<?php

namespace app\modules\__MODULE_NAME__;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * project module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'Smoren\Yii2\AccessManager\controllers';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@module___MODULE_NAME__', '@app/modules/__MODULE_NAME__');

        if($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'Smoren\Yii2\AccessManager\controllers';
        }

        $app->getUrlManager()->addRules([
            /**
             * API авторизации
             * @see IndexController::actionTest()
             *
             * @OA\PathItem(
             *   path="/__MODULE_NAME__/test/{id}",
             *   @OA\Get(
             *     summary="__MODULE_NAME__ test",
             *     tags={"__MODULE_NAME__"},
             *     security={{"apiKey": {}}},
             *     @OA\Parameter(
             *         name="id",
             *         in="path",
             *         description="id",
             *         required=true,
             *         @OA\Schema(type="integer"),
             *     ),
             *     @OA\Response(
             *       response=200,
             *       description="OK",
             *       @OA\MediaType(
             *         mediaType="application/json",
             *       ),
             *     ),
             *   )
             * )
             */
            'GET /__MODULE_NAME__/test/<id:\d+>' => '__MODULE_NAME__/index/test',
        ], false);
    }
}