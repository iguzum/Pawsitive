<?php
namespace App\Controller;
use App\Model\Adoption_Pet;

// :: START ADOPTION PET CONTROLLER
class Adoption_Pet_Controller
{
    private $pet;

    public function __construct()
    {
        $this->pet = new Adoption_Pet();
    }

    public function createPet()
    {
    }

    public function deletePet()
    {
    }

    public function getAllAdoptionPets()
    {
        return $this->pet->getInfo();
    }
}
// :: END ADOPTION PET CONTROLLER
