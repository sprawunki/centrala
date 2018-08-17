<?php

namespace App\Grocy;

use GuzzleHttp\Client;

class ApiClient
{
    /** @var \GuzzleHttp\Client */
    private $httpClient;

    /** @var array */
    private $response;

    public function __construct($args)
    {
        $this->response = [];

        $baseUri = 'https://demo-en.grocy.info/api/';

        if (isset($args['token']) && $args['token']) {
            $baseUri = 'http://zakupki.yhmt.idl.pl/api/';
        }

        $this->httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'    => 5.0,
            'headers' => [
                'GROCY-API-KEY' => $args['token'],
            ],
        ]);
    }

    public function getShoppingList()
    {
        if (!array_key_exists('shoppinglist', $this->response)) {
            $this->response['shoppinglist'] = $this->httpClient->request('GET', 'get-objects/shopping_list')->getBody();
        }

        return (string) $this->response['shoppinglist'];
    }

    public function getProducts()
    {
        if (!array_key_exists('products', $this->response)) {
            $this->response['products'] = $this->httpClient->request('GET', 'get-objects/products')->getBody();
        }

        return (string) $this->response['products'];
    }

    public function getUnits()
    {
        if (!array_key_exists('units', $this->response)) {
            $this->response['units'] = $this->httpClient->request('GET', 'get-objects/quantity_units')->getBody();
        }

        return (string) $this->response['units'];
    }

    public function getLocations()
    {
        if (!array_key_exists('locations', $this->response)) {
            $this->response['locations'] = $this->httpClient->request('GET', 'get-objects/locations')->getBody();
        }

        return (string) $this->response['locations'];
    }

    public function getStock()
    {
        if (!array_key_exists('stock', $this->response)) {
            $this->response['stock'] = $this->httpClient->request('GET', 'stock/get-current-stock')->getBody();
        }

        return (string) $this->response['stock'];
    }

    public function getRecipes()
    {
        if (!array_key_exists('recipes', $this->response)) {
            $this->response['recipes'] = $this->httpClient->request('GET', 'get-objects/recipes')->getBody();
        }

        return (string) $this->response['recipes'];
    }

    public function getIngredients()
    {
        if (!array_key_exists('ingredients', $this->response)) {
            $this->response['ingredients'] = $this->httpClient->request('GET', 'get-objects/recipes_pos')->getBody();
        }

        return (string) $this->response['ingredients'];
    }
}
