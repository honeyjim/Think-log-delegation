<?php

declare (strict_types = 1);

namespace Think\Clogger\Proxy;

use Think\Clogger\CLogger;
use think\Container;
use think\Log as ThinkLog;

class ThinkLogProxy extends ThinkLog
{
    public function createDriver(string $name)
    {
        // $type = $this->resolveType($name);

        $params = $this->resolveParams($name);

        $config = $params[0];
        $config['name'] = $name;

        $driver = new CLogger($config);

        return new ThinkChannelProxy($name, $driver, [], false, null);
    }
}