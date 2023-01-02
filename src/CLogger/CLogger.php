<?php

declare (strict_types = 1);

namespace Think\Clogger;

use Think\Clogger\Handlers\RotationFileHandler;
use Think\Clogger\Processors\IntrospecationProcessor;
use Think\Clogger\Formatters\JsonFormatter;
use think\contract\LogHandlerInterface;
use Monolog\Logger as Monologger;

class CLogger implements LogHandlerInterface
{
    const DEBUG = 100;
    const INFO = 200;
    const NOTICE = 250;
    const WARNING = 300;
    const ERROR = 400;
    const CRITICAL = 500;
    const ALERT = 550;
    const EMERGENCY = 600;

    protected static $levels = [
        self::DEBUG     => 'DEBUG',
        self::INFO      => 'INFO',
        self::NOTICE    => 'NOTICE',
        self::WARNING   => 'WARNING',
        self::ERROR     => 'ERROR',
        self::CRITICAL  => 'CRITICAL',
        self::ALERT     => 'ALERT',
        self::EMERGENCY => 'EMERGENCY',
    ];

    protected static $monologger;

    protected $config;

    protected $level;

    protected $message;

    protected $context;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function setLevel(string $level = null)
    {
        $this->level = $level;
    }

    public function setMessage(string $message = '')
    {
        $this->message = $message;
    }

    public function setContext(array $context = [])
    {
        $this->context = $context;
    }

    public function save(array $log): bool
    {
        $monologger = $this->getMonologger();

        $monologger->addRecord($this->getLevelInt($this->level), $this->message, $this->context);

        return true;
    }

    protected function getMonologger()
    {
        if (self::$monologger instanceof Monologger) {
            return self::$monologger;
        }

        $logger = new Monologger($this->config['name'], $this->parseHandlers(), $this->parseProcessors());

        foreach ($logger->getHandlers() as $handler) {
            foreach ($logger->getProcessors() as $processor) {
                $handler->pushProcessor($processor);
            }
            foreach ($this->parseFormatters() as $formatter) {
                $handler->setFormatter($formatter);
            }
        }

        return self::$monologger = $logger;
    }

    protected function parseHandlers()
    {
        switch ($this->config['type'])
        {
            case 'daily':
                return [new RotationFileHandler($this->config['path'], $this->config['days'])];
            default:
        }
    }

    protected function parseProcessors()
    {
        switch ($this->config['type'])
        {
            case 'daily':
                return [new IntrospecationProcessor($this->getLevelInt($this->level), ['CLogger', 'Think', 'think'])];
            default:
        }
    }

    protected function parseFormatters()
    {
        switch ($this->config['type'])
        {
            case 'daily':
                return [new JsonFormatter()];
            default:
        }
    }

    protected function getLevelInt(string $level = 'DEBUG')
    {
        $level = strtoupper($level);

        $levels = array_flip(self::$levels);

        if (isset($levels[$level]) && $levels[$level]) {
            return $levels[$level];
        }
    }
}
