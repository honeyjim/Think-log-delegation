<?php

declare (strict_types = 1);

namespace Think\Clogger\Handlers;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler as MonologRotationFileHandler;

class RotationFileHandler extends MonologRotationFileHandler
{
    public function __construct(string $filename, int $maxFiles = 7, $level = Logger::DEBUG, bool $bubble = true, int $filePermission = 0777, bool $useLocking = false)
    {
        parent::__construct($filename, $maxFiles, $level, $bubble, $filePermission, $useLocking);
    }
}