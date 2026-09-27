<?php

namespace App\Debug;

use Bitrix\Main\Application;

class CustomLog
{
    private const DEFAULT_CUSTOM_LOG_FILE = 'local/logs/log_custom.log';

    public static function it(string $message, string|null $logFile = null): void
    {
        file_put_contents(self::getLogFilePath($logFile), $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public static function clear(string|null $logFile = null): void
    {
        file_put_contents(self::getLogFilePath($logFile), '');
    }

    private static function getLogFilePath(string|null $logFile = null): string
    {
        return Application::getDocumentRoot() . '/' . ($logFile ?: self::DEFAULT_CUSTOM_LOG_FILE);
    }
}