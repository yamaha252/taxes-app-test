<?php

return [
    'debug' => !!getenv('APP_DEBUG'),
    'connection' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
    ]
];
