<?php
/**
 * Product type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Grocy\Products;
use App\Api\Types;

/**
 * Product type
 */
class ProductType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Product',
            'description' => 'Product',
            'fields' => function () {
                return [
                    'id' => [
                        'type' => Types::int(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getid();
                        }
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getname();
                        }
                    ],
                    'purchaseUnit' => [
                        'type' => Types::unit(),
                        'resolve' => function ($rootValue, $args) {
                            $unitId = $rootValue->getqu_id_purchase();
                            $units = new Products($root);
                            return $units->getUnits($args)
                                ->firstWhere('id', $unitId);
                        }
                    ],
                    'stockLevel' => [
                        'type' => Types::float(),
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
                        'type' => Types::unit(),
                        'resolve' => function ($rootValue, $args) {
                            $unitId = $rootValue->getqu_id_stock();
                            $units = new Products($root);
                            return $units->getUnits($args)
                                ->firstWhere('id', $unitId);
                        }
                    ],
                    'minStockAmount' => [
                        'type' => Types::float(),
                        'resolve' => function ($rootValue, $args) {
                            return $rootValue->getmin_stock_amount();
                        }
                    ],
                    'bestBefore' => [
                        'type' => Types::string(),
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
