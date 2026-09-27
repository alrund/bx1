<?php

namespace App\Debug;

use Bitrix\Main\Diag\ExceptionHandlerFormatter;
use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Config\Configuration;
use Bitrix\Main\Application;

class CustomFileExceptionHandlerLog extends FileExceptionHandlerLog
{
    private const OTUS = 'OTUS';

    protected int $level = 0;

    public function initialize(array $options): void
    {
        if (isset($options["level"]) && $options["level"] > 0)
        {
            $this->level = (int)$options["level"];
        }

        parent::initialize($options);
    }

    /**
     * @param  $exception
     * @param int $logType
     */
    public function write($exception, $logType): void
    {
        $text = ExceptionHandlerFormatter::format($exception, false, $this->level);
        $this->logger->log(
            level: static::logTypeToLevel($logType),
            message: self::OTUS . " {date} - Host: {host} - {type} - {$text}\n",
            context: ['type' => static::logTypeToString($logType)]
        );
    }

    public static function clear(): void
    {
        $config = Configuration::getValue('exception_handling');

        $logFile = $config['log']['settings']['file'] ?? static::DEFAULT_LOG_FILE;
        if (
            !str_starts_with($logFile, '/') &&
            !preg_match('#^[a-z]:/#i', $logFile)
        ) {
            $logFile = Application::getDocumentRoot() . '/' . $logFile;
        }

        file_put_contents($logFile, '');
    }
}