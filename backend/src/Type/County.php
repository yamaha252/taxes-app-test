<?php

namespace Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * County model schema
 * @package Type
 */
class County extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'County',
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'taxRate' => Type::float(),
                'taxAmount' => Type::float(),
            ],
            'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
                return \Resolver\County::{$info->fieldName}($value, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}
