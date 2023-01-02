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
        ],

'sql' => [
            'type' => 'sql',
            'path' => think\Container::getInstance()->make('app')->getRuntimePath().'logs'.DIRECTORY_SEPARATOR.'sql.log',
            'days' => 180,
        ],
```
