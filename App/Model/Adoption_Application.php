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

    // :: START APPLICATION LISTS AND STATUS
    public function getForApplicant(int $accountId): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'SELECT
                aa.application_id,
                aa.status,
                aa.application_date,
                pet.adoption_pet_name
            FROM adoption_application AS aa
            INNER JOIN adoption_pet AS pet
                ON pet.adoption_pet_id = aa.pet_id
            WHERE aa.applicant_id = :account_id
            ORDER BY aa.application_date DESC'
        );
        $stmt->execute(['account_id' => $accountId]);

        return $stmt->fetchAll();
    }

    public function getAllApplications(): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->query(
            'SELECT
                aa.application_id,
                aa.status,
                aa.application_date,
                account.first_name,
                account.last_name,
                account.age AS applicant_age,
                account.email,
                pet.adoption_pet_name,
                pet.species,
                pet.breed,
                pet.age AS pet_age,
                pet.sex AS pet_sex,
                details.address,
                details.monthly_income,
                details.occupation,
                details.household_members,
                details.reason_for_adoption,
                details.is_committed
            FROM adoption_application AS aa
            INNER JOIN account
                ON account.account_id = aa.applicant_id
            INNER JOIN adoption_pet AS pet
                ON pet.adoption_pet_id = aa.pet_id
            LEFT JOIN adoption_application_details AS details
                ON details.application_id = aa.application_id
            ORDER BY aa.application_date DESC'
        );

        return $stmt->fetchAll();
    }

    public function updateStatus(int $applicationId, string $status): bool
    {
        if (!in_array($status, ['Pending', 'Approved', 'Rejected'], true)) {
            return false;
        }

        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            'UPDATE adoption_application
            SET status = :status
            WHERE application_id = :application_id'
        );

        return $stmt->execute([
            'status' => $status,
            'application_id' => $applicationId,
        ]);
    }
    // :: END APPLICATION LISTS AND STATUS

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
        } catch (\Exception $error) {
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
