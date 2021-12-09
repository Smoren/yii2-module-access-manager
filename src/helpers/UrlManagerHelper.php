<?php


namespace Smoren\Yii2\AccessManager\helpers;


use Smoren\ExtendedExceptions\LogicException;
use Yii;
use yii\web\Request;
use yii\web\UrlRule;

class UrlManagerHelper
{
    public static function getSummary(?Request $request = null): array
    {
        $request = $request ?? Yii::$app->request;
        return [
            strtolower($request->method),
            static::getUrlTemplate($request),
        ];
    }

    public static function getRule(?Request $request = null): UrlRule
    {
        $urlManager = Yii::$app->getUrlManager();
        $request = $request ?? Yii::$app->request;
        foreach($urlManager->rules as $rule) {
            if($rule->parseRequest($urlManager, $request) !== false) {
                return $rule;
            }
        }

        throw new LogicException('cannot parse rule', 1);
    }

    public static function getUrlTemplate(?Request $request = null): string
    {
        return static::parseRule(static::getRule($request));
    }

    protected static function parseRule(UrlRule $rule): string
    {
        return preg_replace('/<([\w._-]+):?([^>]+)?>/', '{$1}', $rule->name);
    }
}