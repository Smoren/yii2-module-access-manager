<?php

namespace Smoren\Yii2\AccessManager;

use Smoren\ExtendedExceptions\LogicException;
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
     * Returns DB table prefix
     * @return string
     */
    public static function getDbTablePrefix(): string
    {
        return static::getInstance()->id;
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        static::$dbTablePrefix = $this->id;

        if($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'Smoren\Yii2\AccessManager\commands';
        }

        $app->getUrlManager()->addRules([
            /**
             * API авторизации
             * @see IndexController::actionTest()
             *
             * @OA\PathItem(
             *   path="/access/test/{id}",
             *   @OA\Get(
             *     summary="Access test",
             *     tags={"access"},
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
            'GET /access/test/<id:\d+>' => 'access/index/test',
        ], false);
    }
}