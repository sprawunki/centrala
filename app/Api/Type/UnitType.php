<?php
/**
 * Unit type
 */

namespace App\Api\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use App\Api\Types;

/**
 * Unit type
 */
class UnitType extends ObjectType
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $config = [
            'name' => 'Unit',
            'description' => 'Unit',
            'fields' => [
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
                ]
            ],
        ];
        parent::__construct($config);
    }
}
