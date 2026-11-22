<?php
namespace App\Model;

use App\Config\Connection;

// :: START PREVENTIVE CARE RECORD
class Preventive_Care_Record extends Care_Service_Record
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    public function addRecord(int $requestId): int
    {
        return $this->createRecord($requestId, 'preventive_care_record');
    }
}
// :: END PREVENTIVE CARE RECORD
