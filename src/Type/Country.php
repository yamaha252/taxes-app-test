<?php

namespace Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Country model schema
 * @package Type
 */
class Country extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Country',
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'averageTaxRate' => Type::float(),
                'overallTaxAmount' => Type::float(),
                'states' => Type::listOf(Types::state()),
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\Country::{$info->fieldName}($value, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}

