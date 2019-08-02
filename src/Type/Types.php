<?php

namespace Type;

/**
 * Common types schema
 * @package Type
 */
class Types
{
    private static $query;
    private static $mutation;
    private static $country;
    private static $state;
    private static $county;

    public static function query()
    {
        return self::$query ?: (self::$query = new Query);
    }

    public static function mutation()
    {
        return self::$mutation ?: (self::$mutation = new Mutation);
    }

    public static function country()
    {
        return self::$country ?: (self::$country = new Country);
    }

    public static function state()
    {
        return self::$state ?: (self::$state = new State);
    }

    public static function county()
    {
        return self::$county ?: (self::$county = new County);
    }
}
