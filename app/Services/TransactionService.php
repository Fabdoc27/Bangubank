<?php

namespace App\Services;

use App\Constants\TransactionTypes;
use App\Helpers\FileHelper;
use App\Storage\FileStorage;
use App\Storage\StorageFactory;
use Exception;

class TransactionService {
    private $storage;

    public function __construct() {
        $this->storage = StorageFactory::create();
    }

    public function allTransactions(): array {
        return $this->storage->getTransactions();
    }

    public function getUserTransactions( int $userId ): array {
        return $this->storage->getTransactionsById( $userId );
    }

    public function getUserById( int $id ): array | bool {
        return $this->storage->getUserById( $id );
    }

    public function getUserByEmail( string $email ): array | bool {
        return $this->storage->getUserByEmail( $email );
    }

    public function recordTransaction( int $userId, string $type, int | float $amount, ): void {
        $transactions = $this->storage->getTransactions();

        // Generate a new unique ID for the transaction
        if ( $this->storage instanceof FileStorage ) {
            $id = FileHelper::generateId( $transactions );
        }

        // Create a new transaction array
        $newTransaction = [
            'id'         => $id,
            'user_id'    => $userId,
            'type'       => $type,
            'amount'     => $amount,
            'created_at' => date( 'Y-m-d H:i:s' ),
        ];

        // Save the updated transactions array
        $this->storage->saveTransaction( [$newTransaction] );
    }

    public function deposit( int $userId, int | float $amount ): void {
        $user = $this->storage->getUserById( $userId );

        // Update the user's balance
        $user['balance'] += $amount;

        // Record the transactions
        $this->updateBalanceAndSaveRecord( $userId, $user['balance'], TransactionTypes::DEPOSIT, $amount );
    }

    public function withdraw( int $userId, int | float $amount ): void {
        $user = $this->storage->getUserById( $userId );

        if ( $user['balance'] < $amount ) {
            throw new Exception( 'Insufficient balance' );
        }

        // Update the user's balance
        $user['balance'] -= $amount;

        // Record the transaction
        $this->updateBalanceAndSaveRecord( $userId, $user['balance'], TransactionTypes::WITHDRAW, $amount );
    }

    public function transfer( int $senderId, string $receiverEmail, int | float $amount ): void {
        $sender = $this->storage->getUserById( $senderId );
        $receiver = $this->storage->getUserByEmail( $receiverEmail );

        if ( $sender['balance'] < $amount ) {
            throw new Exception( 'Insufficient balance' );
        }

        // Update balances for both sender and receiver
        $sender['balance'] -= $amount;
        $receiver['balance'] += $amount;

        // Record the transactions
        $this->updateBalanceAndSaveRecord( $senderId, $sender['balance'], TransactionTypes::TRANSFER, $amount );
        $this->updateBalanceAndSaveRecord( $receiver['id'], $receiver['balance'], TransactionTypes::RECEIVE, $amount );
    }

    private function updateBalanceAndSaveRecord( int $userId, int | float $balance, string $type, int | float $amount ): void {
        $this->storage->updateUserBalance( $userId, $balance );
        $this->recordTransaction( $userId, $type, $amount );
    }
}