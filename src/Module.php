<?php

namespace Smoren\Yii2\AccessManager;

use Smoren\Yii2\AccessManager\controllers\ApiController;
use Smoren\Yii2\AccessManager\controllers\ApiGroupController;
use Smoren\Yii2\AccessManager\controllers\RuleController;
use Smoren\Yii2\AccessManager\controllers\WorkerGroupController;
use Smoren\Yii2\AccessManager\interfaces\ApiControllerInterface;
use Smoren\Yii2\AccessManager\interfaces\ApiGroupControllerInterface;
use Smoren\Yii2\AccessManager\interfaces\RuleControllerInterface;
use Smoren\Yii2\AccessManager\interfaces\WorkerGroupControllerInterface;
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
        if($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'Smoren\Yii2\AccessManager\commands';
        }

        $uuidRegexp = '\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b';

        $this->setDefaultController(ApiControllerInterface::class, ApiController::class);
        $this->setDefaultController(ApiGroupControllerInterface::class, ApiGroupController::class);
        $this->setDefaultController(RuleControllerInterface::class, RuleController::class);
        $this->setDefaultController(WorkerGroupControllerInterface::class, WorkerGroupController::class);

        $app->getUrlManager()->addRules(ApiController::getRules("/{$this->id}", "{$this->id}/api", $uuidRegexp));
        $app->getUrlManager()->addRules(ApiGroupController::getRules("/{$this->id}", "{$this->id}/api-group", $uuidRegexp));
        $app->getUrlManager()->addRules(RuleController::getRules("/{$this->id}", "{$this->id}/rule", $uuidRegexp));
        $app->getUrlManager()->addRules(WorkerGroupController::getRules("/{$this->id}", "{$this->id}/worker-group", $uuidRegexp));
    }

    protected function setDefaultController(string $interface, string $class): void
    {
        if (!Yii::$container->has($interface)) {
            Yii::$container->set($interface, $class);
        }
    }
}
