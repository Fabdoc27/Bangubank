<?php

namespace App\Storage;

interface TransactionInterface {
    public function getTransactions(): array;

    public function updateUserBalance( int $userId, int | float $balance ): void;

    public function saveTransaction( array $transaction ): void;
}