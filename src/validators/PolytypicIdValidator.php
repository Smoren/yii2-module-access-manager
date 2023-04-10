<?php

namespace Smoren\Yii2\AccessManager\validators;

use Smoren\ExtendedExceptions\LogicException;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\validators\RegularExpressionValidator;

class PolytypicIdValidator extends RegularExpressionValidator
{
    public $pattern = '/^[0-9]+$/i';

    /**
     * @param ActiveRecord $model
     * @param string $attribute
     * @throws LogicException
     * @throws InvalidConfigException
     */
    public function validateAttribute($model, $attribute)
    {
        if(!($model instanceof ActiveRecord)) {
            throw new LogicException("model is not instance of ActiveRecord", 1);
        }

        $columns = $model->getTableSchema()->columns;

        if(!isset($columns[$attribute])) {
            throw new LogicException("attribute '{$attribute}' does not exist in model", 2);
        }

        switch($columns[$attribute]->phpType) {
            case 'string':
                $this->pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-[1345][0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i';
                break;
            case 'integer':
                $this->pattern = '/^[\-+]{0,1}[0-9]+$/i';
                break;
            default:
                throw new LogicException("bad phpType '{$columns[$attribute]->phpType}' for id column", 3);
        }

        parent::validateAttribute($model, $attribute);
    }
}
