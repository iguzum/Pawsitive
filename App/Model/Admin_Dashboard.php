<?php
namespace App\Model;

use App\Config\Connection;

// :: START ADMIN DASHBOARD MODEL
class Admin_Dashboard
{
    private ?Connection $connection = null;

    public function getMonthlyOverview(): array
    {
        $db = $this->createConnection()->connect();

        $applicationStmt = $db->query(
            "SELECT
                COUNT(*) AS total_applicants,
                COALESCE(SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END), 0) AS awaiting_review
            FROM adoption_application"
        );
        $applicationStats = $applicationStmt->fetch();

        $monthStart = date('Y-m-01');
        $nextMonth = date('Y-m-01', strtotime($monthStart . ' +1 month'));
        // :: START APPROVED MONTHLY SERVICE INCOME
        $serviceStmt = $db->prepare(
            'SELECT
                COUNT(sr.request_id) AS service_bookings,
                COALESCE(SUM(
                    CASE
                        WHEN sr.status = \'Approved\' THEN cs.service_price
                        ELSE 0
                    END
                ), 0) AS monthly_service_income
            FROM service_request AS sr
            INNER JOIN care_service AS cs
                ON cs.service_id = sr.service_id
            WHERE sr.schedule_date >= :month_start
                AND sr.schedule_date < :next_month'
        );
        $serviceStmt->execute([
            'month_start' => $monthStart,
            'next_month' => $nextMonth,
        ]);
        $serviceStats = $serviceStmt->fetch();
        // :: END APPROVED MONTHLY SERVICE INCOME

        return [
            'total_applicants' => (int) ($applicationStats['total_applicants'] ?? 0),
            'awaiting_review' => (int) ($applicationStats['awaiting_review'] ?? 0),
            'service_bookings' => (int) ($serviceStats['service_bookings'] ?? 0),
            'monthly_service_income' => (float) ($serviceStats['monthly_service_income'] ?? 0),
        ];
    }

    private function createConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = new Connection();
        }

        return $this->connection;
    }
}
// :: END ADMIN DASHBOARD MODEL
