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
        // $type = $this->resolveType($name);

        $params = $this->resolveParams($name);

        $config = $params[0];
        $config['name'] = $name;

        $driver = Container::getInstance()->make(CLogger::class, [
            'config' => $config,
        ]);

        return new ThinkChannelProxy($name, $driver, [], false, null);
    }
}