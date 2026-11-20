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
        $careRecord = match ($this->service_id) {
            1 => new General_Care_Record(),
            2 => new Preventive_Care_Record(),
            3 => new Hygiene_Care_Record(),
            4 => new Diagnostic_Care_Record(),
            default => null,
        };

        if ($careRecord === null) {
            return null;
        }

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
                    (pet_id, service_id, request_date, schedule_date)
                VALUES
                    (:pet_id, :service_id, CURRENT_DATE, :schedule_date)'
            );
            $stmt->execute([
                'pet_id' => $petId,
                'service_id' => $this->service_id,
                'schedule_date' => $this->schedule_date,
            ]);
            $requestId = (int) $db->lastInsertId();

            $recordId = $careRecord->addRecord($requestId, $db);

            $db->commit();

            return [
                'pet_id' => $petId,
                'request_id' => $requestId,
                'record_id' => $recordId,
            ];
        } catch (\Exception $error) {
            if ($db->inTransaction()) {
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
// :: END SERVICE REQUEST MODEL
