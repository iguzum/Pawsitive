<?php
namespace App\Model;

use App\Config\Connection;
use PDO;

// :: START REGISTER PET MODEL
final class Register_Pet
{
    private ?Connection $connection = null;

    public function __construct(
        private string $pet_name = '',
        private string $species = '',
        private string $breed = '',
        private int $age = 1,
        private string $sex = ''
    ) {
    }

    public function addClientPet(?PDO $db = null): int
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $accountId = (int) ($_SESSION['user_id'] ?? 0);
        if ($accountId < 1) {
            throw new \RuntimeException('A signed-in account is required to register a pet.');
        }

        $ownsTransaction = $db === null;
        $db ??= $this->createConnection()->connect();

        // :: START EXCEPTION HANDLING
        try {
            if ($ownsTransaction) {
                $db->beginTransaction();
            }

            $stmt = $db->prepare(
                'INSERT INTO pet (account_id, pet_name, species, breed, sex, age)
                VALUES (:account_id, :pet_name, :species, :breed, :sex, :age)'
            );
            $stmt->execute([
                'account_id' => $accountId,
                'pet_name' => $this->pet_name,
                'species' => $this->species,
                'breed' => $this->breed,
                'sex' => $this->sex,
                'age' => $this->age,
            ]);

            $petId = (int) $db->lastInsertId();

            if ($ownsTransaction) {
                $db->commit();
            }

            return $petId;
        } catch (\Exception $error) {
            if ($ownsTransaction && $db->inTransaction()) {
                $db->rollBack();
            }

            throw $error;
        }
        // :: END EXCEPTION HANDLING
    }

    private function createConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = new Connection();
        }

        return $this->connection;
    }
}
// :: END REGISTER PET MODEL
