<?php

namespace App\Grocy;

use App\Grocy\ApiClient;
use Jshannon63\JsonCollect\JsonCollect;

class Products
{
    public function __construct($args)
    {
        $this->token = $args['grocyToken'];
        $this->client = ApiClientFactory::getInstance(['token' => $this->token]);
    }

    public function getItems($args = null)
    {
        $collection = new JsonCollect($this->client->getShoppingList());
        return $collection;
    }

    public function getProducts($args = null)
    {
        $collection = new JsonCollect($this->client->getProducts());
        return $collection;
    }

    public function getUnits($args = null)
    {
        $collection = new JsonCollect($this->client->getUnits());
        return $collection;
    }

    public function getLocations($args = null)
    {
        $collection = new JsonCollect($this->client->getLocations());
        return $collection;
    }

    public function getStock($args = null)
    {
        $collection = new JsonCollect($this->client->getStock());
        return $collection;
    }

    public function getRecipes($args = null)
    {
        $collection = new JsonCollect($this->client->getRecipes());
        return $collection;
    }

    public function getIngredients($args = null)
    {
        $collection = new JsonCollect($this->client->getIngredients());
        return $collection;
    }
}
