<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

function exception_handler($exception)
{
    error_log("Exception: " . $exception->getMessage() . "\nStack trace:\n" . $exception->getTraceAsString() . "\n  thrown in " . $exception->getFile() . " on line " . $exception->getLine());

    include 'src/Error/500.php';
}

set_exception_handler('exception_handler');

$app = new Flashcard\App();

$app->run();
