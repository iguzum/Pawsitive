<?php
namespace App\Model;
use App\Config\Connection;
class Adoption_Pet
{
    private ?Connection $connection = null;
    public function __construct(
        private string $pet_name = '',
        private string $species = '',
        private string $breed = '',
        private string $age = '',
        private string $sex = '',
        private string $behavior_details = '',
        private string $health_condition = '',
        private string $rescue_history = '',
        private string $image = '',
    ) {
    }

    // GET PETS
    public function getInfo()
    {
        $db = $this->createConnection();
        // :: START ORDER ADOPTION PETS
        $stmt = $db->connect()->prepare("
        SELECT p.*, i.health_condition, i.behavior_details, i.rescue_history 
        FROM adoption_pet p
        LEFT JOIN adoption_pet_information i ON i.adoption_pet_id = p.adoption_pet_id
        ORDER BY p.adoption_pet_id DESC
    ");
        // :: END ORDER ADOPTION PETS
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // :: START GET AVAILABLE ADOPTION PETS
    public function getAvailablePets(): array
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare(
            "SELECT p.*, i.health_condition, i.behavior_details, i.rescue_history
            FROM adoption_pet AS p
            LEFT JOIN adoption_pet_information AS i
                ON i.adoption_pet_id = p.adoption_pet_id
            WHERE p.status = :status
            ORDER BY p.adoption_pet_id DESC"
        );
        $stmt->execute(['status' => 'available']);

        return $stmt->fetchAll();
    }
    // :: END GET AVAILABLE ADOPTION PETS

    public function addPet()
    {
        $db = $this->createConnection()->connect();

        try {
            $db->beginTransaction();

            // :: START SAVE ADOPTION PET IMAGE
            $stmt = $db->prepare("INSERT INTO adoption_pet (adoption_pet_name, species, breed, sex, age, image) VALUES(:adoption_pet_name, :species, :breed, :sex, :age, :image)");
            $stmt->execute([
                'adoption_pet_name' => $this->pet_name,
                'species' => $this->species,
                'breed' => $this->breed,
                'sex' => $this->sex,
                'age' => $this->age,
                'image' => $this->image !== '' ? $this->image : null,
            ]);
            // :: END SAVE ADOPTION PET IMAGE

            $adoption_id = $db->lastInsertId();

            $stmt = $db->prepare("INSERT INTO adoption_pet_information (adoption_pet_id, health_condition, behavior_details, rescue_history) VALUES(:adoption_pet_id, :health_condition, :behavior_details, :rescue_history);");
            $stmt->execute([
                'adoption_pet_id' => $adoption_id,
                'health_condition' => $this->health_condition,
                'behavior_details' => $this->behavior_details,
                'rescue_history' => $this->rescue_history,
            ]);

            $db->commit();
            return $adoption_id;

        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    public function deletePet($id)
    {
        $db = $this->createConnection()->connect();
        $stmt = $db->prepare("DELETE FROM adoption_pet WHERE adoption_pet_id = :adoption_pet_id");
        $stmt->execute(['adoption_pet_id' => $id]);
        // :: START RETURN PET DELETE RESULT
        return $stmt->rowCount() > 0;
        // :: END RETURN PET DELETE RESULT
    }
    public function updatePet($id)
    {
        $db = $this->createConnection()->connect();
        try {
            $db->beginTransaction();

            // :: START UPDATE ADOPTION PET AND DETAILS
            $stmt = $db->prepare("UPDATE adoption_pet SET adoption_pet_name = :adoption_pet_name, species = :species, breed = :breed, sex = :sex, age = :age, image = :image WHERE adoption_pet_id = :adoption_pet_id");
            $stmt->execute([
                'adoption_pet_name' => $this->pet_name,
                'species' => $this->species,
                'breed' => $this->breed,
                'sex' => $this->sex,
                'age' => $this->age,
                'image' => $this->image !== '' ? $this->image : null,
                'adoption_pet_id' => $id
            ]);

            $infoCheck = $db->prepare(
                'SELECT adoption_pet_id_info FROM adoption_pet_information
                WHERE adoption_pet_id = :adoption_pet_id LIMIT 1'
            );
            $infoCheck->execute(['adoption_pet_id' => $id]);
            $infoExists = $infoCheck->fetch();

            if ($infoExists) {
                $stmt = $db->prepare(
                    'UPDATE adoption_pet_information
                    SET health_condition = :health_condition,
                        behavior_details = :behavior_details,
                        rescue_history = :rescue_history
                    WHERE adoption_pet_id = :adoption_pet_id'
                );
            } else {
                $stmt = $db->prepare(
                    'INSERT INTO adoption_pet_information
                        (adoption_pet_id, health_condition, behavior_details, rescue_history)
                    VALUES
                        (:adoption_pet_id, :health_condition, :behavior_details, :rescue_history)'
                );
            }

            $stmt->execute([
                'health_condition' => $this->health_condition,
                'behavior_details' => $this->behavior_details,
                'rescue_history' => $this->rescue_history,
                'adoption_pet_id' => $id,
            ]);
            // :: END UPDATE ADOPTION PET AND DETAILS

            $db->commit();
            return true;

        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
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
