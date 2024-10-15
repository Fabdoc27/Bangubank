<?php

namespace App\Storage;

use App\Constants\FilePaths;
use App\Helpers\AppConfig;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserInterface;
use PDO;
use PDOException;

class DatabaseStorage implements UserInterface, TransactionInterface
{
    private PDO $pdo;
    private AppConfig $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
        $dbConfig = $this->config->get('database');

        $this->pdo = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getUsers(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM users');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return [];
        }
    }

    public function isDuplicateEmail(string $email): bool
    {
        try {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return false;
        }
    }

    public function saveUser(array $users): void
    {
        try {
            foreach ($users as $user) {
                $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');

                $stmt->execute([
                    ':name' => $user['name'],
                    ':email' => $user['email'],
                    ':password' => $user['password'],
                    ':role' => $user['role'],
                ]);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
        }
    }

    public function getTransactions(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM transactions');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return [];
        }
    }

    public function updateUserBalance(int $userId, int | float $balance): void
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE users SET balance = :balance WHERE id = :id');

            $stmt->execute([
                ':balance' => $balance,
                ':id' => $userId,
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
        }
    }

    public function saveTransaction(array $transactions): void
    {
        try {
            foreach ($transactions as $transaction) {
                $stmt = $this->pdo->prepare('INSERT INTO transactions (user_id, type, amount) VALUES (:user_id, :type, :amount)');

                $stmt->execute([
                    ':user_id' => $transaction['user_id'],
                    ':type' => $transaction['type'],
                    ':amount' => $transaction['amount'],
                ]);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
        }
    }

    public function getUserById(int $id): array | bool
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return false;
        }
    }

    public function getUserByEmail(string $email): array | bool
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return false;
        }
    }

    public function getTransactionsById(int $userId): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE user_id = :user_id');
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log($e->getMessage() . "\n", 3, FilePaths::LOGS);
            return [];
        }
    }
}