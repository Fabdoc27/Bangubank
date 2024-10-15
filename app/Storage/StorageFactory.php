<?php

namespace App\Storage;

use App\Helpers\AppConfig;

class StorageFactory
{
    private AppConfig $config;
    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    // Creates a storage instance based on the configuration
    public function create()
    {
        $storageType = $this->config->get('storage');

        if ($storageType === 'database') {
            return new DatabaseStorage($this->config);
        }

        return new FileStorage($this->config);
    }
}