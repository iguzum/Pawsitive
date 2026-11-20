<?php
namespace App\Model;

use PDO;

// :: START DIAGNOSTIC CARE RECORD
class Diagnostic_Care_Record extends Care_Service_Record
{
    public function addRecord(int $requestId, ?PDO $db = null): int
    {
        return $this->createRecord(
            $requestId,
            function (PDO $db, int $recordId): void {
                $stmt = $db->prepare(
                    'INSERT INTO diagnostic_care_record (record_id)
                    VALUES (:record_id)'
                );
                $stmt->execute(['record_id' => $recordId]);
            },
            $db
        );
    }
}
// :: END DIAGNOSTIC CARE RECORD
