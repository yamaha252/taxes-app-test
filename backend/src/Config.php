<?php

use Exception\UndefinedConfigParam;

/**
 * Collect app configuration params
 */
class Config
{
    const FILE_MAIN = __DIR__ . '/../config.php';

    const FILE_LOCAL = __DIR__ . '/../config-local.php';

    /**
     * @var array
     */
    private static $configurationData;

    /**
     * Apply main and local files if are exists
     */
    private static function applyFiles()
    {
        static::$configurationData = [];
        static::applyFile(self::FILE_MAIN);
        static::applyFile(self::FILE_LOCAL);
    }

    /**
     * @param string $path Apply configuration file
     */
    private static function applyFile(string $path)
    {
        if (file_exists($path)) {
            self::$configurationData = array_merge(self::$configurationData, include $path);
        }
    }

    /**
     * Get configuration data
     *
     * @param string $name
     * @return mixed
     * @throws UndefinedConfigParam
     */
    public static function get(string $name)
    {
        if (static::$configurationData === null) {
            static::applyFiles();
        }

        if (isset(self::$configurationData[$name])) {
            return self::$configurationData[$name];
        }

        throw new UndefinedConfigParam('Undefined config param ' . $name);
    }
}


