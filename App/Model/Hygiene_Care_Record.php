<?php
namespace App\Model;

use App\Config\Connection;

// :: START HYGIENE CARE RECORD
class Hygiene_Care_Record extends Care_Service_Record
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    public function addRecord(int $requestId): int
    {
        return $this->createRecord($requestId, 'hygiene_care_record');
    }
}
// :: END HYGIENE CARE RECORD
