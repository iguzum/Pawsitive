<?php
namespace App\Interfaces;

interface Authentication_Interface
{
    public function getUserByEmail(string $email): ?array;

    public function createAccount(string $email, string $password): void;
    public function logout(): void;
}