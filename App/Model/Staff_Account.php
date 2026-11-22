<?php
namespace App\Model;

use App\Config\Connection;

// :: START STAFF ACCOUNT MODEL
class Staff_Account
{
    private ?Connection $connection = null;

    public function getAllStaff(): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->query(
            "SELECT account_id, first_name, last_name, email
            FROM account
            WHERE account_role = 'staff'
            ORDER BY first_name, last_name"
        );

        return $stmt->fetchAll();
    }

    public function emailExists(string $email, int $ignoreAccountId = 0): bool
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            "SELECT account_id FROM account
            WHERE email = :email
                AND account_id != :account_id
            LIMIT 1"
        );
        $stmt->execute([
            'email' => $email,
            'account_id' => $ignoreAccountId,
        ]);

        return (bool) $stmt->fetch();
    }

    public function createStaff(array $staff): void
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            "INSERT INTO account (account_role, first_name, last_name, email, password)
            VALUES ('staff', :first_name, :last_name, :email, :password)"
        );
        $stmt->execute([
            'first_name' => $staff['first_name'],
            'last_name' => $staff['last_name'],
            'email' => $staff['email'],
            'password' => password_hash($staff['password'], PASSWORD_DEFAULT),
        ]);
    }

    public function updateStaff(int $accountId, array $staff): bool
    {
        $db = $this->createConnection()->connect();

        if ($staff['password'] !== '') {
            $stmt = $db->prepare(
                "UPDATE account
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    password = :password
                WHERE account_id = :account_id AND account_role = 'staff'"
            );
            $values = [
                'first_name' => $staff['first_name'],
                'last_name' => $staff['last_name'],
                'email' => $staff['email'],
                'password' => password_hash($staff['password'], PASSWORD_DEFAULT),
                'account_id' => $accountId,
            ];
        } else {
            $stmt = $db->prepare(
                "UPDATE account
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email
                WHERE account_id = :account_id AND account_role = 'staff'"
            );
            $values = [
                'first_name' => $staff['first_name'],
                'last_name' => $staff['last_name'],
                'email' => $staff['email'],
                'account_id' => $accountId,
            ];
        }

        $stmt->execute($values);
        return $stmt->rowCount() > 0;
    }

    public function deleteStaff(int $accountId): bool
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            "DELETE FROM account
            WHERE account_id = :account_id AND account_role = 'staff'"
        );
        $stmt->execute(['account_id' => $accountId]);

        return $stmt->rowCount() > 0;
    }

    private function createConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = new Connection();
        }

        return $this->connection;
    }
}
// :: END STAFF ACCOUNT MODEL
