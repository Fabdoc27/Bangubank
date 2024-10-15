<?php

namespace App\Storage;

use App\Helpers\AppConfig;

class StorageFactory
{
    public static function create()
    {
        $storageType = AppConfig::get('storage');

        if ($storageType === 'database') {
            return new DatabaseStorage();
        }

        return new FileStorage();
    }
}
