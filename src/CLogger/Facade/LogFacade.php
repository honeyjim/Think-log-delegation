<?php

declare (strict_types = 1);

namespace app\common\CLogger\Facade;

use app\common\CLogger\Proxy\ThinkLogProxy;
use think\Facade;

class LogFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return ThinkLogProxy::class;
    }
}