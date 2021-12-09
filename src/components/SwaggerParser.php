<?php


namespace Smoren\Yii2\AccessManager\components;


use Smoren\Yii2\AccessManager\models\Api;
use Smoren\ExtendedExceptions\BadDataException;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class SwaggerParser
{
    const ERROR_READ_FILE = 1;
    const ERROR_PARSE_FILE = 2;

    protected $filePath;
    protected $fileData = [];
    protected $apiMap = [];

    /**
     * SwaggerParser constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return $this
     * @throws BadDataException
     */
    public function parse(): self
    {
        $this->fileData = $this->parseFile();
        $this->apiMap = $this->makeApiMap($this->fileData);

        return $this;
    }

    public function update(): array
    {
        $apis = Api::find()->all();

        /** @var Api[] $apiMap */
        $apiMap = ArrayHelper::index($apis, function(Api $api) {
            return $this->createAlias($api->method, $api->path);
        });

        $apiKeysFromDb = array_keys($apiMap);
        $apiKeysFromSwagger = array_keys($this->apiMap);

        $apiKeysToAdd = array_diff($apiKeysFromSwagger, $apiKeysFromDb);
        $apiKeysToDelete = array_diff($apiKeysFromDb, $apiKeysFromSwagger);
        $apiKeysToUpdate = array_intersect($apiKeysFromDb, $apiKeysFromSwagger);

        foreach($apiKeysToAdd as $apiKey) {
            $apiData = $this->apiMap[$apiKey];
            $api = new Api([
                'method' => $apiData['method'],
                'path' => $apiData['path'],
                'title' => $apiData['title'],
                'extra' => ['tags' => $apiData['tags']],
            ]);
            $api->save();
        }

        foreach($apiKeysToDelete as $apiKey) {
            $api = $apiMap[$apiKey];
            $api->delete();
        }

        foreach($apiKeysToUpdate as $apiKey) {
            $api = $apiMap[$apiKey];
            $apiData = $this->apiMap[$apiKey];
            $extra = $api->extra;
            $extra['tags'] = $apiData['tags'];
            $api->title = $apiData['title'];
            $api->save();
        }

        return [
            'added' => count($apiKeysToAdd),
            'deleted' => count($apiKeysToDelete),
            'updated' => count($apiKeysToUpdate),
        ];
    }

    /**
     * @return array
     * @throws BadDataException
     */
    protected function parseFile(): array
    {
        if(!is_file($this->filePath) || !is_readable($this->filePath)) {
            throw new BadDataException('cannot read file', static::ERROR_READ_FILE);
        }
        $data = json_decode(file_get_contents($this->filePath), true);

        if(!is_array($data)) {
            throw new BadDataException('cannot parse file', static::ERROR_PARSE_FILE);
        }

        return $data;
    }

    /**
     * @param array $swaggerFileData
     * @return array
     */
    protected function makeApiMap(array $swaggerFileData): array
    {
        $result = [];

        foreach($swaggerFileData['paths'] as $uri => $methodItems) {
            foreach($methodItems as $method => $item) {
                if(!in_array(strtolower($method), ['get', 'head', 'post', 'put', 'delete', 'connect', 'options', 'trace', 'patch'])) {
                    continue;
                }

                $result[$this->createAlias($method, $uri)] = [
                    'method' => $method,
                    'path' => $uri,
                    'title' => $item['summary'],
                    'tags' => $item['tags'],
                ];
            }
        }

        return $result;
    }

    /**
     * @param string $method
     * @param string $path
     * @return string
     */
    protected function createAlias(string $method, string $path): string
    {
        return "{$path}__{$method}";
    }
}