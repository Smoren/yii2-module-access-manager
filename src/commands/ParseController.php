<?php

namespace Smoren\Yii2\AccessManager\commands;

use Smoren\Yii2\AccessManager\components\SwaggerParser;
use Smoren\ExtendedExceptions\BadDataException;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ParseController
 */
class ParseController extends Controller
{
    /**
     * php yii access/parse/swagger
     * @throws BadDataException
     */
    public function actionSwagger()
    {
        if(isset($_ENV['SWAGGER_JSON_PATH'])) {
            $filePath = "@app/{$_ENV['SWAGGER_JSON_PATH']}";
        } else {
            $filePath = '@app/docker/swagger/data/swagger.json';
        }

        $filePath = Yii::getAlias($filePath);

        while(!is_file($filePath)) {
            $this->stderr("File '$filePath' not found!\n", Console::FG_RED);
            $this->stdout('Input swagger.json file path: ');
            $filePath = Console::stdin();
        }

        $parser = new SwaggerParser($filePath);
        $parser->parse();
        print_r($parser->update());
    }
}
