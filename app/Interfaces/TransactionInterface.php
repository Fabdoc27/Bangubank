<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function getTransactions(): array;
    public function updateUserBalance(int $userId, int | float $balance): void;
    public function saveTransaction(array $transaction): void;
}