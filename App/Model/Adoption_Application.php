<?php
namespace App\Model;

use App\Config\Connection;

// :: START ADOPTION APPLICATION MODEL
class Adoption_Application
{
    private ?Connection $connection = null;

    public function getApplicantProfile(int $accountId): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'SELECT first_name, last_name, age
            FROM account
            WHERE account_id = :account_id'
        );
        $stmt->execute(['account_id' => $accountId]);

        return $stmt->fetch() ?: [
            'first_name' => null,
            'last_name' => null,
            'age' => null,
        ];
    }

    public function submitApplication(int $accountId, array $application): void
    {
        $db = $this->createConnection()->connect();

        try {
            $db->beginTransaction();

            $profileUpdate = $db->prepare(
                'UPDATE account
                SET first_name = :first_name, last_name = :last_name, age = :age
                WHERE account_id = :account_id'
            );
            $profileUpdate->execute([
                'first_name' => $application['first_name'],
                'last_name' => $application['last_name'],
                'age' => $application['age'],
                'account_id' => $accountId,
            ]);

            $applicationInsert = $db->prepare(
                'INSERT INTO adoption_application (applicant_id, pet_id)
                VALUES (:applicant_id, :pet_id)'
            );
            $applicationInsert->execute([
                'applicant_id' => $accountId,
                'pet_id' => $application['pet_id'],
            ]);
            $applicationId = (int) $db->lastInsertId();

            $detailsInsert = $db->prepare(
                'INSERT INTO adoption_application_details
                    (application_id, address, monthly_income, occupation, household_members, reason_for_adoption, is_committed)
                VALUES
                    (:application_id, :address, :monthly_income, :occupation, :household_members, :reason_for_adoption, :is_committed)'
            );
            $detailsInsert->execute([
                'application_id' => $applicationId,
                'address' => $application['address'],
                'monthly_income' => $application['monthly_income'],
                'occupation' => $application['occupation'],
                'household_members' => $application['household_members'],
                'reason_for_adoption' => $application['reason_for_adoption'],
                'is_committed' => $application['is_committed'],
            ]);

            $db->commit();
        } catch (\Throwable $error) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            throw $error;
        }
    }

    private function createConnection(): Connection
    {
        if ($this->connection === null) {
            $this->connection = new Connection();
        }

        return $this->connection;
    }
}
// :: END ADOPTION APPLICATION MODEL
