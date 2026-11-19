<?php
// :: START AUTHENTICATION MODEL NAMESPACE FIX
namespace App\Model;
// :: END AUTHENTICATION MODEL NAMESPACE FIX
use App\Config\Connection;
use App\Interfaces\Authentication_Interface;

class Authentication implements Authentication_Interface
{
    public function getUserByEmail(string $email): ?array
    {
        // :: START ACCOUNT FINDER
        $db = $this->createConnection();
        $stmt = $db->connect()->prepare("SELECT * FROM account WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            return null;
        }
        return $user;
        // :: END ACCOUNT FINDER
    }

    public function createAccount(string $email, string $password): void
    {
        // :: START CUSTOMER ACCOUNT INSERT
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $db = $this->createConnection();
        $stmt = $db->connect()->prepare(
            "INSERT INTO account (account_role, email, password)
            VALUES (:account_role, :email, :password)"
        );
        $stmt->execute([
            'account_role' => 'customer',
            'email' => $email,
            'password' => $hashed,
        ]);
        // :: END CUSTOMER ACCOUNT INSERT
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
    }


    private function createConnection(): Connection
    {
        return new Connection();
    }
}
