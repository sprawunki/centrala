<?php
/**
 * Grocy API client factory
 */

namespace App\Grocy;

use App\Grocy\ApiClient;

/**
 * Grocy API client factory
 */
final class ApiClientFactory
{
    /**
     * Call this method to get singleton
     *
     * @param array $args Configuration.
     * @return ApiClient A Grocy API client instance.
     */
    public static function getInstance(array $args)
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new ApiClient(['token' => $args['token']]);
        }
        return $inst;
    }

    /**
     * Class constructor
     *
     * It's private so nobody else can instantiate it
     */
    private function __construct()
    {
    }
}
