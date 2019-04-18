<?php
/**
 * Grocy Products
 */

namespace App\Grocy;

use App\Grocy\ApiClient;
use Jshannon63\JsonCollect\JsonCollect;

/**
 * Grocy Products
 */
class Products
{
    /** @var string */
    private $token;

    /** @var ApiClient */
    private $client;

    /**
     * Constructor
     *
     * @param array $args Configuraton.
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct($args)
    {
        $this->token = $args['grocyToken'];
        // TODO Clean this up once dependency injection is in place.
        $this->client = ApiClientFactory::getInstance(['token' => $this->token]);
    }

    /**
     * Get shopping list items
     *
     * @return JsonCollect Shopping list item collection
     */
    public function getItems()
    {
        $collection = new JsonCollect($this->client->getShoppingList());
        return $collection;
    }

    /**
     * Get products
     *
     * @return JsonCollect Product collection
     */
    public function getProducts()
    {
        $collection = new JsonCollect($this->client->getProducts());
        return $collection;
    }

    /**
     * Get units
     *
     * @return JsonCollect Unit collection
     */
    public function getUnits()
    {
        $collection = new JsonCollect($this->client->getUnits());
        return $collection;
    }

    /**
     * Get locations
     *
     * @return JsonCollect Location collection
     */
    public function getLocations()
    {
        $collection = new JsonCollect($this->client->getLocations());
        return $collection;
    }

    /**
     * Get stock
     *
     * @return JsonCollect Stock collection
     */
    public function getStock()
    {
        $collection = new JsonCollect($this->client->getStock());
        return $collection;
    }

    /**
     * Get recipes
     *
     * @return JsonCollect Recipe collection
     */
    public function getRecipes()
    {
        $collection = new JsonCollect($this->client->getRecipes());
        return $collection;
    }

    /**
     * Get ingredients
     *
     * @return JsonCollect Ingredient collection
     */
    public function getIngredients()
    {
        $collection = new JsonCollect($this->client->getIngredients());
        return $collection;
    }
}
