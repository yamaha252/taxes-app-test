<?php
require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use GraphQL\Error\FormattedError;
use GraphQL\Error\Debug;
use Type\Query;

try {
    $debug = false;
    if (Config::get('debug')) {
        set_error_handler(function ($severity, $message, $file, $line) use (&$phpErrors) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });
        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
    }

    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true) ?: [];

    $schema = new Schema([
        'query' => new Query()
    ]);

    $result = GraphQL::executeQuery(
        $schema,
        $data['query'],
        null,
        null,
        $data['variables'] ?? null
    );
    $output = $result->toArray($debug);
    $httpStatus = 200;
} catch (Exception $error) {
    $httpStatus = 500;
    $output['errors'] = [
        FormattedError::createFromException($error, $debug)
    ];
}

header('Content-Type: application/json', true, $httpStatus);
echo json_encode($output);
