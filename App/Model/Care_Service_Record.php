<?php
namespace App\Model;

use App\Config\Connection;

// :: START ABSTRACT CARE SERVICE RECORD
abstract class Care_Service_Record
{
    public function __construct(protected Connection $connection)
    {
    }

    abstract public function addRecord(int $requestId): int;

    protected function createRecord(int $requestId, string $detailsTable): int
    {
        $db = $this->connection->connect();
        $ownsTransaction = !$db->inTransaction();

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
            $detailsStmt = $db->prepare(
                "INSERT INTO {$detailsTable} (record_id) VALUES (:record_id)"
            );
            $detailsStmt->execute(['record_id' => $recordId]);

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
}
// :: END ABSTRACT CARE SERVICE RECORD
