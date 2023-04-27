<?php

namespace Smoren\Yii2\AccessManager;

use Smoren\Helpers\EnvHelper;
use Smoren\Yii2\AccessManager\controllers\ApiApiGroupController;
use Smoren\Yii2\AccessManager\controllers\ApiController;
use Smoren\Yii2\AccessManager\controllers\ApiGroupController;
use Smoren\Yii2\AccessManager\controllers\PermissionController;
use Smoren\Yii2\AccessManager\controllers\RuleController;
use Smoren\Yii2\AccessManager\controllers\WorkerController;
use Smoren\Yii2\AccessManager\controllers\WorkerGroupController;
use Smoren\Yii2\AccessManager\controllers\WorkerGroupRuleController;
use Smoren\Yii2\AccessManager\controllers\WorkerWorkerGroupController;
use Smoren\Yii2\AccessManager\helpers\BehaviorFactory;
use Smoren\Yii2\AccessManager\interfaces\BehaviorFactoryInterface;
use Smoren\Yii2\AccessManager\interfaces\WorkerRepositoryInterface;
use Smoren\Yii2\AccessManager\repository\WorkerRepository;
use yii\base\Application;
use yii\base\BootstrapInterface;
use Yii;

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
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'Smoren\Yii2\AccessManager\commands';
        }

        $uuidRegexp = '\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b';

        $this->setDefaultDiClass(BehaviorFactoryInterface::class, BehaviorFactory::class);
        $this->setDefaultDiClass(WorkerRepositoryInterface::class, WorkerRepository::class);

        $app->getUrlManager()->addRules(array_merge(
            ApiController::getRules("/{$this->id}/api", "{$this->id}/api", $uuidRegexp),
            ApiGroupController::getRules("/{$this->id}/api-group", "{$this->id}/api-group", $uuidRegexp),
            ApiApiGroupController::getRules("/{$this->id}/api-api-group", "{$this->id}/api-api-group"),
            WorkerGroupController::getRules("/{$this->id}/worker-group", "{$this->id}/worker-group", $uuidRegexp),
            WorkerWorkerGroupController::getRules("/{$this->id}/worker-worker-group", "{$this->id}/worker-worker-group"),
            PermissionController::getRules("/{$this->id}/permission", "{$this->id}/permission"),
            RuleController::getRules("/{$this->id}/rule", "{$this->id}/rule", $uuidRegexp),
            WorkerGroupRuleController::getRules("/{$this->id}/worker-group-rule", "{$this->id}/worker-group-rule"),
            WorkerController::getRules("/{$this->id}/worker", "{$this->id}/worker", $uuidRegexp)
        ));
    }

    protected function setDefaultDiClass(string $interface, string $class): void
    {
        if (!Yii::$container->has($interface)) {
            Yii::$container->setSingleton($interface, $class);
        }
    }
}
