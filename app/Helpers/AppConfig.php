<?php

namespace App\Helpers;

use App\Constants\FilePaths;

class AppConfig
{
    private static array $config;

    public static function get(string $key): mixed
    {
        if ( ! isset(self::$config)) {
            self::$config = require FilePaths::CONFIG;
        }

        return self::$config[$key];
    }
}
