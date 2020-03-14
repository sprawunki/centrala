<?php
/**
 * Application bootstrap
 *
 */

use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use App\Grocy\Products;
use App\Api\Types;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

try {
    $schema = new Schema([
        'query' => Types::query()
    ]);

    $rawInput = $_GET['q'];
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;
    $rootValue = ['grocyToken' => $input['tokens']['grocy']];
    $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output = $result->toArray(true);
} catch (\Exception $exception) {
    $output = [
        'error' => [
            'message' => $exception->getMessage()
        ]
    ];
}

$emitter = new SapiEmitter();
$emitter->emit(
    new JsonResponse($output)
);
