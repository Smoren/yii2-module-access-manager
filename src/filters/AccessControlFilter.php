<?php

namespace Smoren\Yii2\AccessManager\filters;

use Smoren\Yii2\AccessManager\components\ApiAccessChecker;
use Smoren\Yii2\Auth\exceptions\ApiException;
use yii\base\ActionFilter;

class AccessControlFilter extends ActionFilter
{
    /**
     * @param $action
     * @return bool
     * @throws ApiException
     */
    public function beforeAction($action): bool
    {
        $methodsExcept = method_exists($this->owner, 'getMethodsExcept')
            ? $this->owner->getMethodsExcept()
            : ['options', 'OPTIONS'];

        ApiAccessChecker::createFromRequestContext()
            ->exceptMethods($methodsExcept)
            ->checkAccess();

        return parent::beforeAction($action);
    }
}
