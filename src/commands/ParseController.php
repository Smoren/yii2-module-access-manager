<?php

namespace Smoren\Yii2\AccessManager\commands;

use Smoren\Yii2\AccessManager\components\SwaggerParser;
use Smoren\ExtendedExceptions\BadDataException;
use Yii;
use yii\base\NotSupportedException;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ParseController
 */
class ParseController extends Controller
{
    const SWAGGER_FILE_NAME = 'swagger.json';

    /**
     * php yii access/parse/swagger
     * @throws BadDataException
     */
    public function actionSwagger(bool $parseApiGroupsFromTags = false)
    {
        // TODO use flag
        $filePath = $this->getSwaggerFilePath();

        while(!is_file($filePath)) {
            $this->stderr("File '$filePath' not found!\n", Console::FG_RED);
            $this->stdout('Input swagger.json file path: ');
            $filePath = Console::stdin();
        }

        $parser = new SwaggerParser($filePath);
        $parser->parse();
        $summary = $parser->update();

        $this->stdout("[SUCCESS]\n\n", Console::FG_GREEN);
        $this->stdout("Summary:\n");
        print_r($summary);
    }

    /**
     * @return string
     */
    protected function getSwaggerFilePath(): string
    {
        if(isset($_ENV['SWAGGER_JSON_PATH'])) {
            $filePath = Yii::getAlias("@app/{$_ENV['SWAGGER_JSON_PATH']}");
            if(is_file($filePath)) {
                return $filePath;
            }
        }

        $invMessage = 'Input '.static::SWAGGER_FILE_NAME.' file path';

        $this->stdout($invMessage);
        try {
            $filePath = $this->findSwaggerFilePath();
            $this->stdout(" (Default: {$filePath})", Console::FG_YELLOW);
        } catch(BadDataException $e) {
            $filePath = null;
        }
        $this->stdout(":\n");

        $input = trim(Console::stdin());
        $filePath = $input ? $input : $filePath;

        while(!is_file($filePath)) {
            $this->stderr("File '$filePath' not found!\n", Console::FG_RED);
            $this->stdout("{$invMessage}:\n");
            $filePath = Console::stdin();
        }

        return $filePath;
    }

    /**
     * @return mixed
     * @throws BadDataException
     */
    protected function findSwaggerFilePath(): string
    {
        if(strpos(strtolower(PHP_OS), 'win') !== false) {
            throw new BadDataException('cannot search for files on windows', 2);
        }

        $shellResponse = trim(shell_exec('find -name '.static::SWAGGER_FILE_NAME.' -not -path "./vendor/*"'));

        if(!$shellResponse) {
            throw new BadDataException('file '.static::SWAGGER_FILE_NAME.' not found', 1);
        }

        $result = explode("\n", $shellResponse);

        return realpath($result[0]);
    }
}
