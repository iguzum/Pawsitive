<?php
namespace App\Model;

use PDO;

// :: START HYGIENE CARE RECORD
class Hygiene_Care_Record extends Care_Service_Record
{
    public function addRecord(int $requestId, ?PDO $db = null): int
    {
        return $this->createRecord(
            $requestId,
            function (PDO $db, int $recordId): void {
                $stmt = $db->prepare(
                    'INSERT INTO hygiene_care_record (record_id)
                    VALUES (:record_id)'
                );
                $stmt->execute(['record_id' => $recordId]);
            },
            $db
        );
    }
}
// :: END HYGIENE CARE RECORD
