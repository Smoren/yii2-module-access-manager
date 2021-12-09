# yii2-module-access-manager
Access manager and control module for Yii2

### How to install to Yii2 project
```
composer require smoren/yii2-module-access-manager
```

### Path 1
Simply include in your config:
```
...
'modules' => [
    ...
    'access' => ['class' => 'Smoren\Yii2\AccessManager\Module'],
],
...
'bootstrap' => [
    ...
    'access',
],
...
'controllerMap' => [
    'migrate' => [
        'class' => MigrateController::class,
        'migrationPath' => [
            ...
            'vendor/smoren/yii2-module-access-manager/src/migrations',
        ],
    ],
],
...
```

Then run migrations:
```
php yii migrate
```
