<?php
namespace App\Model;

use App\Config\Connection;
use PDO;

// :: START ABSTRACT CARE SERVICE RECORD
abstract class Care_Service_Record
{
    private ?Connection $connection = null;

    abstract public function addRecord(int $requestId, ?PDO $db = null): int;

    protected function createRecord(
        int $requestId,
        callable $insertCareDetails,
        ?PDO $db = null
    ): int
    {
        $ownsTransaction = $db === null;
        $db ??= $this->createConnection()->connect();

        // :: START EXCEPTION HANDLING
        try {
            if ($ownsTransaction) {
                $db->beginTransaction();
            }

            $stmt = $db->prepare(
                'INSERT INTO care_service_record (request_id, record_date)
                VALUES (:request_id, CURRENT_DATE)'
            );
            $stmt->execute(['request_id' => $requestId]);

            $recordId = (int) $db->lastInsertId();
            $insertCareDetails($db, $recordId);

            if ($ownsTransaction) {
                $db->commit();
            }

            return $recordId;
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
// :: END ABSTRACT CARE SERVICE RECORD
