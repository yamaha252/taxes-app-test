<?php

namespace Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class Mutation extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'generateData' => [
                    'type' => Type::boolean(),
                ]
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\Mutation::{$info->fieldName}($args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}
