<?php
/**
 * Ingredient type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Grocy\Products;
use App\Api\Types;

/**
 * Ingredient type
 */
class IngredientType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Ingredient',
            'description' => 'Ingredient',
            'fields' => function () {
                return [
                    'id' => [
                        'type' => Types::int(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getid();
                        }
                    ],
                    'amount' => [
                        'type' => Types::float(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getamount();
                        }
                    ],
                    'product' => [
                        'type' => Types::product(),
                        'resolve' => function ($rootValue, $args) {
                            $productId = $rootValue->getproduct_id();
                            $products = new Products($root);
                            return $products->getProducts($args)->firstWhere('id', $productId);
                        }
                    ],
                ];
            },
            'resolveField' => function ($product, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($user, $args, $context, $info);
                }
                return $product[$info->fieldName];
            }
        ];
        parent::__construct($config);
    }
}
