<?php

namespace Smoren\Yii2\AccessManager\models;

use Smoren\Yii2\AccessManager\models\query\ApiApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiGroupQuery;
use Smoren\Yii2\AccessManager\models\query\ApiQuery;
use Smoren\Yii2\AccessManager\structs\Constants;
use Smoren\Yii2\ActiveRecordExplicit\models\ActiveRecord;
use thamtech\uuid\validators\UuidValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access_api".
 *
 * @property string $id
 * @property string $method
 * @property string $path
 * @property string $title
 * @property string|null $extra
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property ApiApiGroup[] $apiApiGroups
 * @property ApiGroup[] $apiGroups
 */
class Api extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::getAlias(Constants::TABLE_PREFIX_ALIAS).'_api';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', UuidValidator::class],
            [['method', 'path', 'title'], 'required'],
            [['extra'], 'safe'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['method'], 'string', 'max' => 10],
            [['path', 'title'], 'string', 'max' => 255],
            [['method', 'path'], 'unique', 'targetAttribute' => ['method', 'path']],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => 'Method',
            'path' => 'Path',
            'title' => 'Title',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ApiApiGroups]].
     *
     * @return ActiveQuery|ApiApiGroupQuery
     */
    public function getApiApiGroups()
    {
        return $this->hasMany(ApiApiGroup::class, ['api_id' => 'id']);
    }

    /**
     * Gets query for [[ApiGroups]].
     *
     * @return ActiveQuery|ApiGroupQuery
     * @throws InvalidConfigException
     */
    public function getApiGroups()
    {
        return $this->hasMany(ApiGroup::class, ['id' => 'api_group_id'])->viaTable('access_api_api_group', ['api_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ApiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApiQuery(get_called_class());
    }
}
