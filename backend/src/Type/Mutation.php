<?php

namespace Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class Mutation extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'generateData' => [
                    'type' => Types::query(),
                    'description' => 'Generates data and returns query',
                ]
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\Mutation::{$info->fieldName}($args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}
