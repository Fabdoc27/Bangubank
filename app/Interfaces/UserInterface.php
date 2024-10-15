<?php

namespace App\Interfaces;

interface UserInterface
{
    public function getUsers(): array;
    public function isDuplicateEmail(string $email): bool;
    public function saveUser(array $user): void;
}