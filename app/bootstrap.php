<?php
/**
 * Application bootstrap
 *
 */

use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use App\Grocy\Products;
use App\Api\Types;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

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

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);
