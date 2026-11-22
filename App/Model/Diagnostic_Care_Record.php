<?php
namespace App\Model;

use App\Config\Connection;

// :: START DIAGNOSTIC CARE RECORD
class Diagnostic_Care_Record extends Care_Service_Record
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    public function addRecord(int $requestId): int
    {
        return $this->createRecord($requestId, 'diagnostic_care_record');
    }
}
// :: END DIAGNOSTIC CARE RECORD
