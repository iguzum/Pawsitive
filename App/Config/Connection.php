<?php
namespace App\Config;

use PDO;
use RuntimeException;
use PDOException;

class Connection
{
    private ?PDO $pdo = null;

    public function __construct(
        private string $host = 'localhost',
        private string $dbname = 'pawsitive',
        private string $user = 'root',
        private string $password = ''
    ) {
    }

    public function connect(): PDO
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            return $this->pdo;

        } catch (PDOException $e) {
            throw new RuntimeException(
                'Database connection failed. Check your configuration.',
                previous: $e
            );
        }
    }
}
?>