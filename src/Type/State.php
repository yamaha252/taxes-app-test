<?php

namespace Type;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * State model schema
 * @package Type
 */
class State extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'State',
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'overallTaxAmount' => Type::float(),
                'averageTaxAmount' => Type::float(),
                'averageTaxRate' => Type::float(),
                'counties' => new ListOfType(Types::county()),
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\State::{$info->fieldName}($value, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}

