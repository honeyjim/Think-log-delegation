<?php

declare (strict_types = 1);

namespace Think\Clogger\Proxy;

use Think\Clogger\CLogger;
use think\helper\Str;
use think\Container;
use think\Log as ThinkLog;
use think\exception\FuncNotFoundException;

class ThinkLogProxy extends ThinkLog
{
    public function createDriver(string $name)
    {
        $type = $this->resolveType($name);

        $method = 'create' . Str::studly($type) . 'Driver';

        $params = $this->resolveParams($name);

        if (method_exists($this, $method)) {
            return $this->$method($name, $params);
        }

        throw new FuncNotFoundException(sprintf('Logger driver method %s not found', $method));
    }

    public function createDailyDriver($channelName, $config)
    {
        $config = $config[0];
        $config['name'] = $channelName;
        $driver = Container::getInstance()->make(CLogger::class, [
            'config' => $config,
        ]);

        return new ThinkChannelProxy($channelName, $driver, [], false, null);
    }
}