<?php
/**
 * Query type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\Api\Types;
use App\Grocy\Products;

/**
 * Query type
 */
class QueryType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'items' => [
                    'type' => Types::listOf(Types::shoppingListItem()),
                    'resolve' => function ($root) {
                        $products = new Products($root);
                        return $products->getItems($args);
                    }
                ],
                'locations' => [
                    'type' => Types::listOf(Types::location()),
                    'description' => 'Retrns a list of all locations',
                    'resolve' => function ($root) {
                        $products = new Products($root);
                        return $products->getLocations($args);
                    }
                ],
                'products' => [
                    'type' => Types::listOf(Types::product()),
                    'resolve' => function ($root) {
                        $products = new Products($root);
                        return $products->getProducts($args);
                    }
                ],
                'recipes' => [
                    'type' => Types::listOf(Types::recipe()),
                    'resolve' => function ($root) {
                        $products = new Products($root);
                        return $products->getRecipes($args);
                    }
                ],
            ]
        ];

        parent::__construct($config);
    }
}
