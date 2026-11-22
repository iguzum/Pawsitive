<?php
namespace App\Model;

use App\Config\Connection;

// :: START GENERAL CARE RECORD
class General_Care_Record extends Care_Service_Record
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    public function addRecord(int $requestId): int
    {
        return $this->createRecord($requestId, 'general_care_record');
    }
}
// :: END GENERAL CARE RECORD
