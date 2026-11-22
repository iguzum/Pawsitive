<?php
namespace App\Controller;

// :: START ABSTRACT STATUS CONTROLLER
abstract class Abstract_Status_Controller
{
    abstract public function updateStatus(int $recordId, string $status): bool;
}
// :: END ABSTRACT STATUS CONTROLLER
