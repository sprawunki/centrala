<?php
/**
 * Shopping list item
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Grocy\Products;
use App\Api\Types;

/**
 * Shopping list item
 */
class ShoppingListItemType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'ShoppingListItem',
            'description' => 'Shopping list item',
            'fields' => function () {
                return [
                    'id' => [
                        'type' => Types::int(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getid();
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
                    'amount' => [
                        'type' => Types::float(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getamount() + $rootValue->getamount_autoadded();
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
