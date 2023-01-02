<?php

declare (strict_types = 1);

namespace Think\Clogger\Facade;

use Think\Clogger\Proxy\ThinkLogProxy;
use think\Facade;

class LogFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return ThinkLogProxy::class;
    }
}