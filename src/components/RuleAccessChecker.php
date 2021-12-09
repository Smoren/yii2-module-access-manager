<?php


namespace Smoren\Yii2\AccessManager\components;


use Smoren\Yii2\AccessManager\helpers\UrlManagerHelper;
use Smoren\Yii2\AccessManager\models\Api;
use Smoren\Yii2\AccessManager\models\ApiApiGroup;
use Smoren\Yii2\AccessManager\models\ApiGroup;
use Smoren\Yii2\AccessManager\models\Permission;
use Smoren\Yii2\AccessManager\models\Rule;
use Smoren\Yii2\AccessManager\models\UserGroup;
use Smoren\Yii2\AccessManager\models\UserGroupRule;
use Smoren\Yii2\AccessManager\models\UserUserGroup;
use Smoren\ExtendedExceptions\BaseException;
use Smoren\Yii2\Auth\exceptions\ApiException;
use Smoren\Yii2\Auth\structs\StatusCode;
use Yii;
use yii\base\BaseObject;
use yii\db\Connection;
use yii\db\Query;

class RuleAccessChecker
{
    protected $userId;
    protected $dbConn;

    public static function createFromRequestContext(?Connection $dbConn = null): self
    {
        return new static(Yii::$app->user->identity->id, $dbConn);
    }

    public function __construct(string $userId, ?Connection $dbConn = null)
    {
        $this->userId = $userId;
        $this->dbConn = $dbConn ?? Yii::$app->db;
    }

    public function checkAccess(string $ruleAlias): self
    {
        $grantCount = (new Query())
            ->select('ugr.rule_id')
            ->from(['r' => Rule::tableName()])
            ->innerJoin(['ugr' => UserGroupRule::tableName()], 'ugr.rule_id = r.id')
            ->innerJoin(['ug' => UserGroup::tableName()], 'ug.id = ugr.user_group_id')
            ->innerJoin(['uug' => UserUserGroup::tableName()], 'uug.user_group_id = ug.id and uug.user_id = :user_id', [':user_id' => $this->userId])
            ->andWhere(['r.alias' => $ruleAlias])
            ->count('ugr.rule_id', $this->dbConn);

        if(!$grantCount) {
            throw new ApiException('access denied', StatusCode::FORBIDDEN);
        }

        return $this;
    }
}