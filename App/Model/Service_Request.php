<?php
namespace App\Model;

use App\Config\Connection;
use PDO;

// :: START SERVICE REQUEST MODEL
class Service_Request
{
    private ?Connection $connection = null;

    public function __construct(
        private string $pet_name = '',
        private string $species = '',
        private string $breed = '',
        private string $age = '',
        private string $sex = '',
        private int $service_id = 0,
        private string $schedule_date = ''
    ) {
    }

    public function addRequest(): ?array
    {
        // :: START SAVE SCHEDULER REQUEST ONLY
        $db = $this->createConnection()->connect();

        // :: START EXCEPTION HANDLING
        try {
            $db->beginTransaction();

            $pet = new Register_Pet(
                $this->pet_name,
                $this->species,
                $this->breed,
                (int) $this->age,
                $this->sex
            );
            $petId = $pet->addClientPet($db);

            $stmt = $db->prepare(
                'INSERT INTO service_request
                    (status, pet_id, service_id, request_date, schedule_date)
                VALUES
                    (:status, :pet_id, :service_id, CURRENT_DATE, :schedule_date)'
            );
            $stmt->execute([
                'status' => 'Pending',
                'pet_id' => $petId,
                'service_id' => $this->service_id,
                'schedule_date' => $this->schedule_date,
            ]);
            $requestId = (int) $db->lastInsertId();

            $db->commit();

            return [
                'pet_id' => $petId,
                'request_id' => $requestId,
            ];
        } catch (\Exception $error) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            throw $error;
        }
        // :: END EXCEPTION HANDLING
        // :: END SAVE SCHEDULER REQUEST ONLY
    }

    // :: START SERVICE REQUEST LISTS AND STATUS
    public function getForAccount(int $accountId): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'SELECT
                sr.request_id,
                sr.status,
                sr.request_date,
                sr.schedule_date,
                pet.pet_name,
                service.service_name
            FROM service_request AS sr
            INNER JOIN pet
                ON pet.pet_id = sr.pet_id
            INNER JOIN care_service AS service
                ON service.service_id = sr.service_id
            WHERE pet.account_id = :account_id
            ORDER BY sr.schedule_date DESC, sr.request_id DESC'
        );
        $stmt->execute(['account_id' => $accountId]);

        return $stmt->fetchAll();
    }

    public function getAllRequests(): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->query(
            'SELECT
                sr.request_id,
                sr.status,
                sr.request_date,
                sr.schedule_date,
                pet.pet_name,
                service.service_name,
                account.first_name,
                account.last_name,
                account.email
            FROM service_request AS sr
            INNER JOIN pet
                ON pet.pet_id = sr.pet_id
            INNER JOIN account
                ON account.account_id = pet.account_id
            INNER JOIN care_service AS service
                ON service.service_id = sr.service_id
            ORDER BY sr.schedule_date DESC, sr.request_id DESC'
        );

        return $stmt->fetchAll();
    }

    public function updateStatus(int $requestId, string $status): bool
    {
        if (!in_array($status, ['Pending', 'Approved', 'Rejected'], true)) {
            return false;
        }

        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'UPDATE service_request
            SET status = :status
            WHERE request_id = :request_id'
        );

        return $stmt->execute([
            'status' => $status,
            'request_id' => $requestId,
        ]);
    }

    // :: START DELETE CARE SERVICE REQUEST
    public function deleteRequest(int $requestId): bool
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'DELETE FROM service_request
            WHERE request_id = :request_id'
        );

        $stmt->execute(['request_id' => $requestId]);

        return $stmt->rowCount() > 0;
    }
    // :: END DELETE CARE SERVICE REQUEST
    // :: END SERVICE REQUEST LISTS AND STATUS

    private function createConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = new Connection();
        }

        return $this->connection;
    }
}
// :: END SERVICE REQUEST MODEL
