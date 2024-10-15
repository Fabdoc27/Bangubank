<?php

namespace App\Controllers;

use App\Helpers\AppConfig;
use App\Storage\StorageFactory;

class AdminController
{
    private $storage;

    public function __construct()
    {
        $config = AppConfig::getInstance();
        $factory = new StorageFactory($config);
        $this->storage = $factory->create();
    }

    public function usersList(): array
    {
        $data = $this->storage->getUsers();

        // get all users with role "customer"
        $users = array_filter($data, fn($user) => $user['role'] === "customer");

        // for latest records to show first
        $sortedList = array_reverse($users);

        return $sortedList;
    }

    public function searchUserByEmail(string $email): array
    {
        $data = $this->storage->getUsers();
        $users = array_filter($data, fn($user) => $user['email'] === $email);

        return $users;
    }

    public function userInfo(int $userId): array
    {
        return $this->storage->getUserById($userId);
    }

    public function transactionsList(): array
    {
        // Retrieve and reverse transactions for latest records first
        return array_reverse($this->storage->getTransactions());
    }

    public function transactionsById(int $userId): array
    {
        // for latest records to show first
        return array_reverse($this->storage->getTransactionsById($userId));
    }
}