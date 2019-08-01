<?php

namespace Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Root query model schema
 * @package Type
 */
class Query extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'countries' => [
                    'type' => Type::listOf(Types::country()),
                    'description' => 'Returns subset of countries',
                ],
                'country' => [
                    'type' => Types::country(),
                    'description' => 'Returns a country by id',
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ],
                'states' => [
                    'type' => Type::listOf(Types::state()),
                    'description' => 'Returns subset of states',
                ],
                'state' => [
                    'type' => Types::state(),
                    'description' => 'Returns a state by id',
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ],
                'counties' => [
                    'type' => Type::listOf(Types::county()),
                    'description' => 'Returns subset of counties',
                ],
                'county' => [
                    'type' => Types::county(),
                    'description' => 'Returns a county by id',
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ],
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\Query::{$info->fieldName}($args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}
