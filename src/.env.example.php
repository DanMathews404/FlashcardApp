<?php

declare(strict_types = 1);

namespace Flashcard;

$variables = [
    'APP_DOMAIN' => "localhost"
];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
