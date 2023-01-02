<?php

declare (strict_types = 1);

namespace Think\Clogger\Proxy;

use think\log\Channel as ThinkChannel;

class ThinkChannelProxy extends ThinkChannel
{
    public function record($msg, string $type = 'info', array $context = [], bool $lazy = true)
    {
        $this->logger->setLevel($type);
        $this->logger->setMessage($msg);
        $this->logger->setContext($context);

        $this->logger->save([$msg]);
    }
}