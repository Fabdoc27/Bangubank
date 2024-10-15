<?php

namespace App\Services;

use App\Helpers\AppConfig;
use App\Helpers\FileHelper;
use App\Storage\FileStorage;
use App\Storage\StorageFactory;
use Exception;

class AuthService
{
    private $storage;

    public function __construct()
    {
        $config = AppConfig::getInstance();
        $factory = new StorageFactory($config);
        $this->storage = $factory->create();
    }

    public function isExistingUser(string $email): bool
    {
        return $this->storage->isDuplicateEmail($email);
    }

    public function registerUser(string $name, string $email, string $password, string $role = "customer", int $id = null): void
    {
        $users = $this->storage->getUsers();

        // Generate a new ID
        if ($id === null && $this->storage instanceof FileStorage) {
            $id = FileHelper::generateId($users);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create the new user array
        $newUser = [
            'id' => $id,
            'role' => $role,
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'balance' => 0,
        ];

        // Add the new user
        $this->storage->saveUser([$newUser]);
    }

    public function authenticateUser(string $email, string $password): array
    {
        $users = $this->storage->getUsers();

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                if (password_verify($password, $user['password'])) {
                    return $user;
                } else {
                    throw new Exception('Invalid password');
                }
            }
        }

        throw new Exception('User not found');
    }
}