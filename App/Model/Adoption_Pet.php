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
        $stmt = $db->connect()->prepare("
        SELECT p.*, i.health_condition, i.behavior_details, i.rescue_history 
        FROM adoption_pet p
        LEFT JOIN adoption_pet_information i ON i.adoption_pet_id = p.adoption_pet_id
    ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addPet()
    {
        $db = $this->createConnection()->connect();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO adoption_pet (adoption_pet_name, species, breed, sex, age) VALUES(:adoption_pet_name, :species, :breed, :sex, :age);");
            $stmt->execute([
                'adoption_pet_name' => $this->pet_name,
                'species' => $this->species,
                'breed' => $this->breed,
                'sex' => $this->sex,
                'age' => $this->age
            ]);

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
        return $stmt->execute(['adoption_pet_id' => $id]);
    }
    public function updatePet($id)
    {
        $db = $this->createConnection()->connect();
        try {
            $db->beginTransaction();

            $stmt = $db->prepare("UPDATE adoption_pet SET adoption_pet_name = :adoption_pet_name, species = :species, breed = :breed, sex = :sex, age = :age WHERE adoption_pet_id = :adoption_pet_id");
            $stmt->execute([
                'adoption_pet_name' => $this->pet_name,
                'species' => $this->species,
                'breed' => $this->breed,
                'sex' => $this->sex,
                'age' => $this->age,
                'adoption_pet_id' => $id
            ]);


            $stmt = $db->prepare("UPDATE adoption_pet_information SET health_condition = :health_condition, behavior_details = :behavior_details, rescue_history = :rescue_history WHERE adoption_pet_id = :adoption_pet_id");
            $stmt->execute([
                'health_condition' => $this->health_condition,
                'behavior_details' => $this->behavior_details,
                'rescue_history' => $this->rescue_history,
                'adoption_pet_id' => $id
            ]);

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
