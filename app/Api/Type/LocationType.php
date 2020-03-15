<?php
/**
 * Location type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Grocy\Products;
use App\Api\Types;

/**
 * Location type
 */
class LocationType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Location',
            'description' => 'Stock location',
            'fields' => function () {
                return [
                    'name' => [
                        'type' => Types::string(),
                    ],
                    'products' => [
                        'type' => Types::listOf(Types::product()),
                        'resolve' => function ($rootValue) {
                            $locationId = $rootValue->getid();
                            $products = new Products($root);
                            return $products->getProducts($args)->where('location_id', $locationId)
                                ->where('parent_product_id', null);
                        }
                    ],
                ];
            },
            'resolveField' => function ($location, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($user, $args, $context, $info);
                }
                return $location[$info->fieldName];
            }
        ];
        parent::__construct($config);
    }

    private function resolveProducts() {
        return [
            [
                'name' => 'Foo'
            ]
        ];
    }
}
