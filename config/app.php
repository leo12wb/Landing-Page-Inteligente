<?php

declare(strict_types=1);

return [
    'name'    => $_ENV['APP_NAME']    ?? 'DevFlow',
    'env'     => $_ENV['APP_ENV']     ?? 'development',
    'debug'   => filter_var($_ENV['APP_DEBUG'] ?? 'false', FILTER_VALIDATE_BOOLEAN),
    'version' => $_ENV['APP_VERSION'] ?? '1.0.0',
    'url'     => $_ENV['APP_URL']     ?? 'http://localhost:8080',
];
