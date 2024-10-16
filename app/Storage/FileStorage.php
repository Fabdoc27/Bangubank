<?php

namespace App\Storage;

use App\Constants\FilePaths;
use App\Helpers\AppConfig;
use App\Helpers\FileHelper;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserInterface;

class FileStorage implements UserInterface, TransactionInterface
{
    private AppConfig $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    public function getUsers(): array
    {
        return FileHelper::readFile(FilePaths::USERS);
    }

    public function isDuplicateEmail(string $email): bool
    {
        $users = $this->getUsers();

        // Checks if the given email already exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }

        return false;
    }

    public function saveUser(array $newUser): void
    {
        $users = $this->getUsers();

        foreach ($newUser as $user) {
            $users[] = $user;
        }

        FileHelper::writeFile(FilePaths::USERS, $users);
    }

    public function getTransactions(): array
    {
        return FileHelper::readFile(FilePaths::TRANSACTIONS);
    }

    public function updateUserBalance(int $userId, int | float $balance): void
    {
        $users = $this->getUsers();

        // Iterate over users to update the balance for the matching user
        foreach ($users as &$user) {
            if ($user['id'] === $userId) {
                $user['balance'] = $balance;
                break;
            }
        }

        FileHelper::writeFile(FilePaths::USERS, $users);
    }

    public function saveTransaction(array $newTransaction): void
    {
        $transactions = $this->getTransactions();

        foreach ($newTransaction as $transaction) {
            $transactions[] = $transaction;
        }

        FileHelper::writeFile(FilePaths::TRANSACTIONS, $transactions);
    }

    public function getUserById(int $id): array | bool
    {
        $users = $this->getUsers();

        // Iterate over users to find the one with the matching ID
        foreach ($users as $user) {
            if ($user['id'] === $id) {
                return $user;
            }
        }

        return false;
    }

    public function getUserByEmail(string $email): array | bool
    {
        $users = $this->getUsers();

        // Iterate over users to find the one with the matching email
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }

        return false;
    }

    public function getTransactionsById(int $userId): array
    {
        $transactions = $this->getTransactions();

        // Filter transactions to get only those for the specified customer
        $userTransactions = array_filter(
            $transactions, fn($transaction) => $transaction['user_id'] === $userId
        );

        return $userTransactions;
    }
}