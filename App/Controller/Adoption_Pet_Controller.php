<?php
namespace App\Controller;
use App\Model\Adoption_Pet;
use Exception;

// :: START ADOPTION PET CONTROLLER
class Adoption_Pet_Controller
{
    private $pet;

    public function __construct()
    {
        $this->pet = new Adoption_Pet();
    }

    // :: START ADOPTION PET CRUD ACTIONS
    public function createPet(array $form): array
    {
        $petData = $this->validatePet($form);
        if ($petData['error'] !== '') {
            return ['success' => false, 'message' => $petData['error']];
        }

        try {
            $pet = $this->makePet($petData['data']);
            $pet->addPet();
            return ['success' => true, 'message' => 'Adoption pet added.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not add the adoption pet.'];
        }
    }

    public function updatePet(array $form): array
    {
        $petId = filter_var($form['pet_id'] ?? null, FILTER_VALIDATE_INT);
        if ($petId === false || $petId < 1) {
            return ['success' => false, 'message' => 'Choose a valid pet.'];
        }

        $petData = $this->validatePet($form);
        if ($petData['error'] !== '') {
            return ['success' => false, 'message' => $petData['error']];
        }

        try {
            $pet = $this->makePet($petData['data']);
            $pet->updatePet($petId);
            return ['success' => true, 'message' => 'Adoption pet updated.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not update the adoption pet.'];
        }
    }

    public function deletePet(int $petId): array
    {
        if ($petId < 1) {
            return ['success' => false, 'message' => 'Choose a valid pet.'];
        }

        try {
            $deleted = $this->pet->deletePet($petId);
            return $deleted
                ? ['success' => true, 'message' => 'Adoption pet removed.']
                : ['success' => false, 'message' => 'Adoption pet was not found.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not remove the adoption pet.'];
        }
    }
    // :: END ADOPTION PET CRUD ACTIONS

    public function getAllAdoptionPets()
    {
        return $this->pet->getInfo();
    }

    // :: START GET AVAILABLE PETS FOR CATALOG
    public function getAvailableAdoptionPets(): array
    {
        return $this->pet->getAvailablePets();
    }
    // :: END GET AVAILABLE PETS FOR CATALOG

    // :: START ADOPTION PET FORM VALIDATION
    private function validatePet(array $form): array
    {
        $name = trim((string) ($form['pet_name'] ?? ''));
        $species = strtolower(trim((string) ($form['species'] ?? '')));
        $breed = trim((string) ($form['breed'] ?? ''));
        $sex = strtolower(trim((string) ($form['sex'] ?? '')));
        $age = filter_var($form['age'] ?? null, FILTER_VALIDATE_INT);
        $image = trim((string) ($form['image'] ?? ''));
        $health = trim((string) ($form['health_condition'] ?? ''));
        $behavior = trim((string) ($form['behavior_details'] ?? ''));
        $rescue = trim((string) ($form['rescue_history'] ?? ''));

        if (
            $name === '' || strlen($name) > 100
            || !in_array($species, ['dog', 'cat'], true)
            || $breed === '' || strlen($breed) > 50
            || !in_array($sex, ['male', 'female'], true)
            || $age === false || $age < 0 || $age > 255
            || strlen($image) > 255
            || strlen($health) > 255
        ) {
            return ['error' => 'Complete the pet fields with valid values.', 'data' => []];
        }

        return [
            'error' => '',
            'data' => [
                'name' => $name,
                'species' => $species,
                'breed' => $breed,
                'sex' => $sex,
                'age' => (string) $age,
                'image' => $image,
                'health' => $health,
                'behavior' => $behavior,
                'rescue' => $rescue,
            ],
        ];
    }

    private function makePet(array $data): Adoption_Pet
    {
        return new Adoption_Pet(
            $data['name'],
            $data['species'],
            $data['breed'],
            $data['age'],
            $data['sex'],
            $data['behavior'],
            $data['health'],
            $data['rescue'],
            $data['image']
        );
    }
    // :: END ADOPTION PET FORM VALIDATION
}
// :: END ADOPTION PET CONTROLLER
