<?php

namespace App\Helpers;

use App\Constants\FilePaths;

class AppConfig
{
    private static $instance = null;
    private array $config;

    // Private constructor to prevent instantiation
    private function __construct()
    {
        $this->config = require FilePaths::CONFIG;
    }

    // Static method to get the single instance
    public static function getInstance(): AppConfig
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Public method to get config value
    public function get(string $key): mixed
    {
        return $this->config[$key] ?? null;
    }
}