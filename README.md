# Delegate log to Monolog for ThinkPHP6
## Usage
* composer require hh/clogger

```php
use Think\Clogger\Facade\LogFacade as Log;

Log::channel('main')->debug('test info', [
            'context' => ['It`s Cool'],
        ])
```

* Configurations
```php
 'main' => [
            'type' => 'daily',
            'path' => think\Container::getInstance()->make('app')->getRuntimePath().'logs'.DIRECTORY_SEPARATOR.'main.log',
            'days' => 180,
        ]
```
* Sql log
```php
Db::listen(function ($sql, $time, $master) {
    $dbLogger = new Logger('db.logger');
    $handler = new RotatingFileHandler(Container::getInstance()->make('app')->getRuntimePath().'logs'.DIRECTORY_SEPARATOR.'sql.log', 180);
    $dbLogger->pushHandler($handler);

    if (0 === strpos($sql, 'CONNECT:')) {
        $dbLogger->info($sql);
        return;
    }

    if (is_bool($master)) {
        $master = $master ? 'master|' : 'slave|';
    } else {
        $master = '';
    }

    $dbLogger->info($sql . ' [ ' . $master . 'RunTime:' . $time . 's ]');
});
```
