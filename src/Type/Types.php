<?php

namespace Type;

/**
 * Common types schema
 * @package Type
 */
class Types
{
    private static $country;
    private static $state;
    private static $county;

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
