<?php
/**
 * Recipe type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Grocy\Products;
use App\Api\Types;

/**
 * Recipe type
 */
class RecipeType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Recipe',
            'description' => 'Recipe',
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
                    'ingredients' => [
                        'type' => Types::listOf(Types::ingredient()),
                        'resolve' => function ($rootValue, $args) {
                            $recipeId = $rootValue->getid();
                            $collection = new Products($root);
                            return $collection->getIngredients($args)->where('recipe_id', $recipeId);
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
