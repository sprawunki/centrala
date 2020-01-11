<?php
/**
 * Application bootstrap
 *
 * phpcs:disable ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine
 */

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use App\Grocy\Products;

require __DIR__ . '/../vendor/autoload.php';

try {
    $unitType = new ObjectType([
        'name' => 'Unit',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'name' => [
                'type' => Type::string(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getname();
                }
            ]
        ],
    ]);

    $productType = new ObjectType([
        'name' => 'Product',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'name' => [
                'type' => Type::string(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getname();
                }
            ],
            'purchaseUnit' => [
                'type' => $unitType,
                'resolve' => function ($rootValue, $args) {
                    $unitId = $rootValue->getqu_id_purchase();
                    $units = new Products($root);
                    return $units->getUnits($args)
                        ->firstWhere('id', $unitId);
                }
            ],
            'stockLevel' => [
                'type' => Type::float(),
                'resolve' => function ($rootValue, $args) {
                    $productId = $rootValue->getid();
                    $stock = new Products($root);
                    $stockItem = $stock->getStock($args)
                        ->firstWhere('product_id', $productId);
                    if ($stockItem) {
                        return $stockItem->getamount();
                    }
                    return 0;
                }
            ],
            'stockUnit' => [
                'type' => $unitType,
                'resolve' => function ($rootValue, $args) {
                    $unitId = $rootValue->getqu_id_stock();
                    $units = new Products($root);
                    return $units->getUnits($args)
                        ->firstWhere('id', $unitId);
                }
            ],
            'minStockAmount' => [
                'type' => Type::float(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getmin_stock_amount();
                }
            ],
            'bestBefore' => [
                'type' => Type::string(),
                'resolve' => function ($rootValue, $args) {
                    $productId = $rootValue->getid();
                    $stock = new Products($root);
                    $stockItem = $stock->getStock($args)->firstWhere('product_id', $productId);
                    if ($stockItem) {
                        return $stockItem->getbest_before_date();
                    }
                    return null;
                }
            ],
        ],
    ]);

    $locationType = new ObjectType([
        'name' => 'Location',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'name' => [
                'type' => Type::string(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getname();
                }
            ],
            'products' => [
                'type' => Type::listOf($productType),
                'resolve' => function ($rootValue) {
                    $locationId = $rootValue->getid();
                    $products = new Products($root);
                    return $products->getProducts($args)->where('location_id', $locationId);
                }
            ],
        ],
    ]);

    $itemType =  new ObjectType([
        'name' => 'Shopping List Item',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'product' => [
                'type' => $productType,
                'resolve' => function ($rootValue, $args) {
                    $productId = $rootValue->getproduct_id();
                    $products = new Products($root);
                    return $products->getProducts($args)->firstWhere('id', $productId);
                }
            ],
            'amount' => [
                'type' => Type::float(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getamount() + $rootValue->getamount_autoadded();
                }
            ],
        ],
    ]);

    $ingredientType =  new ObjectType([
        'name' => 'Ingredient',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'amount' => [
                'type' => Type::float(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getamount();
                }
            ],
            'product' => [
                'type' => $productType,
                'resolve' => function ($rootValue, $args) {
                    $productId = $rootValue->getproduct_id();
                    $products = new Products($root);
                    return $products->getProducts($args)->firstWhere('id', $productId);
                }
            ],
        ],
    ]);

    $recipeType =  new ObjectType([
        'name' => 'Recipe',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getid();
                }
            ],
            'name' => [
                'type' => Type::string(),
                'resolve' => function ($rootValue, $args) {
                    return $rootValue->getname();
                }
            ],
            'ingredients' => [
                'type' => Type::listOf($ingredientType),
                'resolve' => function ($rootValue, $args) {
                    $recipeId = $rootValue->getid();
                    $collection = new Products($root);
                    return $collection->getIngredients($args)->where('recipe_id', $recipeId);
                }
            ]
        ],
    ]);

    $queryType = new ObjectType([
        'name' => 'Shopping List',
        'fields' => [
            'items' => [
                'type' => Type::listOf($itemType),
                'resolve' => function ($root) {
                    $products = new Products($root);
                    return $products->getItems($args);
                }
            ],
            'products' => [
                'type' => Type::listOf($productType),
                'resolve' => function ($root) {
                    $products = new Products($root);
                    return $products->getProducts($args);
                }
            ],
            'locations' => [
                'type' => Type::listOf($locationType),
                'resolve' => function ($root) {
                    $products = new Products($root);
                    return $products->getLocations($args);
                }
            ],
            'recipes' => [
                'type' => Type::listOf($recipeType),
                'resolve' => function ($root) {
                    $products = new Products($root);
                    return $products->getRecipes($args);
                }
            ],
        ],
    ]);

    $schema = new Schema([
        'query' => $queryType,
        'item' => $itemType,
        'product' => $productType,
        'unit' => $unitType,
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
