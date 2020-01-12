<?php

namespace App\Api;

use App\Api\Type\QueryType;
use App\Api\Type\IngredientType;
use App\Api\Type\LocationType;
use App\Api\Type\ProductType;
use App\Api\Type\RecipeType;
use App\Api\Type\ShoppingListItemType;
use App\Api\Type\UnitType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;

class Types
{
    private static $query;
    private static $location;
    private static $ingredient;
    private static $product;
    private static $recipe;
    private static $unit;
    private static $shoppingListItem;

    public static function ingredient()
    {
        return self::$ingredient ?: (self::$ingredient = new IngredientType());
    }

    public static function location()
    {
        return self::$location ?: (self::$location = new LocationType());
    }

    public static function product()
    {
        return self::$product ?: (self::$product = new ProductType());
    }

    public static function recipe()
    {
        return self::$recipe ?: (self::$recipe = new RecipeType());
    }

    public static function unit()
    {
        return self::$unit ?: (self::$unit = new UnitType());
    }

    public static function shoppingListItem()
    {
        return self::$shoppingListItem ?: (self::$shoppingListItem = new ShoppingListItemType());
    }

    /**
     * @return QueryType
     */
    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @return \GraphQL\Type\Definition\FloatType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }
}
