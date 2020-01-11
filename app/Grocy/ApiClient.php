<?php
/**
 * Grocy API Client
 */

namespace App\Grocy;

use GuzzleHttp\Client;

/**
 * Grocy API Client
 */
class ApiClient
{
    /** @var \GuzzleHttp\Client */
    private $httpClient;

    /** @var array */
    private $response;

    /**
     * Constructor
     *
     * @param array $args Constructor arguments.
     */
    public function __construct(array $args)
    {
        $this->response = [];

        $baseUri = getenv('GROCY_API_URL_ANONYMOUS');

        if (isset($args['token']) && $args['token'] !== '') {
            $baseUri = getenv('GROCY_API_URL');
        }

        $this->httpClient = new Client([
            // Base URI is used with relative requests.
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'    => 5.0,
            'headers' => [
                'GROCY-API-KEY' => $args['token'],
            ],
        ]);
    }

    /**
     * Get shopping list
     *
     * @return string
     */
    public function getShoppingList()
    {
        if (!array_key_exists('shoppinglist', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/shopping_list');
            $this->response['shoppinglist'] = $apiResponse->getBody();
        }

        return (string) $this->response['shoppinglist'];
    }

    /**
     * Get products
     *
     * @return string
     */
    public function getProducts()
    {
        if (!array_key_exists('products', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/products');
            $this->response['products'] = $apiResponse->getBody();
        }

        return (string) $this->response['products'];
    }

    /**
     * Get measurement units
     *
     * @return string
     */
    public function getUnits()
    {
        if (!array_key_exists('units', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/quantity_units');
            $this->response['units'] = $apiResponse->getBody();
        }

        return (string) $this->response['units'];
    }

    /**
     * Get stock locations
     *
     * @return string
     */
    public function getLocations()
    {
        if (!array_key_exists('locations', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/locations');
            $this->response['locations'] = $apiResponse->getBody();
        }

        return (string) $this->response['locations'];
    }

    /**
     * Get stock
     *
     * @return string
     */
    public function getStock()
    {
        if (!array_key_exists('stock', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'stock');
            $this->response['stock'] = $apiResponse->getBody();
        }

        return (string) $this->response['stock'];
    }

    /**
     * Get recipes
     *
     * @return string
     */
    public function getRecipes()
    {
        if (!array_key_exists('recipes', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/recipes');
            $this->response['recipes'] = $apiResponse->getBody();
        }

        return (string) $this->response['recipes'];
    }

    /**
     * Get recipe ingredient mapping
     *
     * @return string
     */
    public function getIngredients()
    {
        if (!array_key_exists('ingredients', $this->response)) {
            $apiResponse = $this->httpClient
                ->request('GET', 'objects/recipes_pos');
            $this->response['ingredients'] = $apiResponse->getBody();
        }

        return (string) $this->response['ingredients'];
    }
}
