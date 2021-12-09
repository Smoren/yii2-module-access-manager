<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\ApiApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiQuery;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_api_api_group".
 *
 * @property string $api_id
 * @property string $api_group_id
 * @property int $created_at
 *
 * @property Api $api
 * @property ApiGroup $apiGroup
 */
class ApiApiGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_api_api_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['api_id', 'api_group_id'], UuidValidator::class],
            [['api_id', 'api_group_id'], 'required'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['api_id', 'api_group_id'], 'unique', 'targetAttribute' => ['api_id', 'api_group_id']],
            [['api_id'], 'exist', 'skipOnError' => true, 'targetClass' => Api::class, 'targetAttribute' => ['api_id' => 'id']],
            [['api_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApiGroup::class, 'targetAttribute' => ['api_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'api_id' => 'Api ID',
            'api_group_id' => 'Api Group ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Api]].
     *
     * @return ActiveQuery|ApiQuery
     */
    public function getApi()
    {
        return $this->hasOne(Api::class, ['id' => 'api_id']);
    }

    /**
     * Gets query for [[ApiGroup]].
     *
     * @return ActiveQuery|ApiGroupQuery
     */
    public function getApiGroup()
    {
        return $this->hasOne(ApiGroup::class, ['id' => 'api_group_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiApiGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiApiGroupQuery(get_called_class());
    }
}
