# yii2-module-access-manager
Access manager and control module for Yii2

### How to install to Yii2 project
```
composer require smoren/yii2-module-access-manager
```

### After install
Include into Yii2 config:
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

Include into Yii2 env file:
```
...
ACCESS_WORKER_TABLE='the existing table you want to be access worker table'
...
```

Then run migrations:
```
php yii migrate
```

Also you can choose another module id if you already have your own module named "access".