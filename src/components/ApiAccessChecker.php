<?php


namespace Smoren\Yii2\AccessManager\components;


use Smoren\Yii2\AccessManager\helpers\UrlManagerHelper;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\UserGroup;
use Smoren\Yii2\AccessManager\models\UserUserGroup;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;
use yii\db\Connection;
use yii\db\Query;

class ApiAccessChecker
{
    protected $method;
    protected $path;
    protected $userId;
    protected $dbConn;
    protected $methodsExcept = [];

    public static function createFromRequestContext(?Connection $dbConn = null): self
    {
        [$method, $path] = UrlManagerHelper::getSummary();
        return new static($method, $path, Yii::$app->user->identity->id, $dbConn);
    }

    public function __construct(string $method, string $path, string $userId, ?Connection $dbConn = null)
    {
        $this->method = $method;
        $this->path = $path;
        $this->userId = $userId;
        $this->dbConn = $dbConn ?? Yii::$app->db;
    }

    public function exceptMethods(array $methods): self
    {
        $this->methodsExcept = $methods;
        return $this;
    }

    public function checkAccess(): self
    {
        if(in_array($this->method, $this->methodsExcept)) {
            return $this;
        }

        $grantCount = (new Query())
            ->select('p.api_group_id')
            ->from(['a' => Api::tableName()])
            ->innerJoin(['aag' => ApiApiGroup::tableName()], 'aag.api_id = a.id')
            ->innerJoin(['ag' => ApiGroup::tableName()], 'ag.id = aag.api_group_id')
            ->innerJoin(['p' => Permission::tableName()], 'p.api_group_id = ag.id')
            ->innerJoin(['ug' => UserGroup::tableName()], 'ug.id = p.user_group_id')
            ->innerJoin(['uug' => UserUserGroup::tableName()], 'uug.user_group_id = ug.id and uug.user_id = :user_id', [':user_id' => $this->userId])
            ->andWhere(['a.method' => $this->method])
            ->andWhere(['a.path' => $this->path])
            ->count('p.api_group_id', $this->dbConn);

        if(!$grantCount) {
            throw new ApiException('access denied', StatusCode::FORBIDDEN);
        }

        return $this;
    }

    public function checkRule(string $ruleAlias): self
    {
        (new RuleAccessChecker($this->userId, $this->dbConn))->checkAccess($ruleAlias);
        return $this;
    }
}