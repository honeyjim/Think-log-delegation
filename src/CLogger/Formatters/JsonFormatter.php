<?php

declare (strict_types = 1);

namespace Think\Clogger\Formatters;

use think\Container;
use Monolog\Formatter\JsonFormatter as MonologJsonFormatter;

class JsonFormatter extends MonologJsonFormatter
{
    public function format(array $record): string
    {
        $duration = number_format(microtime(true) - Container::getInstance()->make('app')->getBeginTime(), 3);
        $url = Container::getInstance()->make('request')->url(true);
        $method = Container::getInstance()->make('request')->method();
        $parameters = Container::getInstance()->make('request')->param();
        $ip = Container::getInstance()->make('request')->ip();
        $traceId = Container::getInstance()->make('request')->header('trace_id');
        $serverAddr = isset($_SERVER['SERVER_ADDR']) ? (string)$_SERVER['SERVER_ADDR'] : '';
        $serverServerName = isset($_SERVER['SERVER_NAME']) ? (string)$_SERVER['SERVER_NAME'] : '';
        $httpReferer = isset($_SERVER['HTTP_REFERER']) ? (string)$_SERVER['HTTP_REFERER'] : '';
        $token = isset($_SERVER['HTTP_AUTHORIZATION']) ? (string)$_SERVER['HTTP_AUTHORIZATION'] : '';
        $device = Container::getInstance()->make('request')->header('byplatform') ?? 'unknown';

        $newRecord = [
            'project_name' => '',
            'request_id' => '',
            'level' => $record['level_name'],
            'request_time' => $record['datetime']->format('Y-m-d H:i:s.u'),
            'message' => $record['message'],
            'context' => json_encode($record['context'], JSON_UNESCAPED_UNICODE),
            'duration' => ($duration / 1000).' ms',
            'clientIp' => $ip,
            'traceId' => $traceId,
            'serverAddress' => $serverAddr,
            'serverName' => $serverServerName,
            'referer' => $httpReferer,
            'url' => $url,
            'method' => $method,
            'parameters' => $parameters,
            'token' => $token,
            'device' => $device,
        ];

        if (isset($record['extra'])) {
            $newRecord['file_name'] = $record['extra']['file'] ?? '';
            $newRecord['line'] = $record['extra']['line'] ?? '';
            $newRecord['class'] = $record['extra']['class'] ?? '';
            $newRecord['function_name'] = $record['extra']['function'] ?? '';
        }

        return $this->toJson($this->normalize($newRecord), true) . ($this->appendNewline ? "\n" : '');
    }
}