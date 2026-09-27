<?php

use App\Debug\CustomFileExceptionHandlerLog;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
\App\Debug\CustomFileExceptionHandlerLog::clear();

LocalRedirect('/homeworks/homework2/');
