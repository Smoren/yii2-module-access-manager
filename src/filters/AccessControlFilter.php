<?php


namespace Smoren\Yii2\AccessManager\filters;


use Smoren\Yii2\AccessManager\components\ApiAccessChecker;
use yii\base\ActionFilter;

class AccessControlFilter extends ActionFilter
{
    public function beforeAction($action)
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