<?php

namespace App\Grocy;

use App\Grocy\ApiClient;

final class ApiClientFactory
{
    /**
     * Call this method to get singleton
     *
     * @return UserFactory
     */
    public static function getInstance($args)
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new ApiClient(['token' => $args['token']]);
        }
        return $inst;
    }

    /**
     * Private constructor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
    }
}
