<?php
namespace App\Controller;

use App\Model\Service_Request;

// :: START SERVICE REQUEST CONTROLLER
// :: START SERVICE REQUEST STATUS CONTROLLER OVERRIDE
class Service_Request_Controller extends Abstract_Status_Controller
    // :: END SERVICE REQUEST STATUS CONTROLLER OVERRIDE
{
    private Service_Request $serviceRequest;

    // :: START SERVICE REQUEST CONTROLLER SETUP
    public function __construct(?Service_Request $serviceRequest = null)
    {
        $this->serviceRequest = $serviceRequest ?? new Service_Request();
    }
    // :: END SERVICE REQUEST CONTROLLER SETUP

    // :: START SERVICE REQUEST STATUS OVERRIDE
    public function updateStatus(int $recordId, string $status): bool
    {
        return $this->serviceRequest->updateStatus($recordId, $status);
    }
    // :: END SERVICE REQUEST STATUS OVERRIDE

    public function submitRequest(array $form, int $accountId): array
    {
        if ($accountId < 1) {
            return [
                'success' => false,
                'message' => 'Please sign in before booking an appointment.',
                'step' => 1,
            ];
        }

        $petName = trim((string) ($form['pet_name'] ?? ''));
        $species = (string) ($form['species'] ?? '');
        $breed = trim((string) ($form['breed'] ?? ''));
        $age = filter_var($form['age'] ?? null, FILTER_VALIDATE_INT);
        $sex = (string) ($form['sex'] ?? '');

        if (
            $petName === '' || strlen($petName) > 100
            || !in_array($species, ['Dog', 'Cat'], true)
            || strlen($breed) > 50
            || $age === false || $age < 0 || $age > 255
            || !in_array($sex, ['Male', 'Female'], true)
        ) {
            return [
                'success' => false,
                'message' => 'Please enter valid pet details.',
                'step' => 1,
            ];
        }

        $scheduleDate = (string) ($form['schedule_date'] ?? '');
        $dateParts = explode('-', $scheduleDate);
        $serviceId = filter_var($form['service_id'] ?? null, FILTER_VALIDATE_INT);
        $validScheduleDate = count($dateParts) === 3
            && checkdate((int) $dateParts[1], (int) $dateParts[2], (int) $dateParts[0])
            && $scheduleDate >= date('Y-m-d');

        if (!$validScheduleDate || $serviceId === false || !in_array($serviceId, [1, 2, 3, 4], true)) {
            return [
                'success' => false,
                'message' => 'Please choose a valid appointment date and care service.',
                'step' => 2,
            ];
        }

        try {
            $request = new Service_Request(
                $petName,
                $species,
                $breed,
                (string) $age,
                $sex,
                $serviceId,
                $scheduleDate
            );
            $savedRequest = $request->addRequest();

            if ($savedRequest === null) {
                return [
                    'success' => false,
                    'message' => 'We could not save your appointment. Please try again.',
                    'step' => 2,
                ];
            }

            return [
                'success' => true,
                'message' => 'Your care appointment has been submitted.',
                'step' => 2,
            ];
        } catch (\Exception $error) {
            return [
                'success' => false,
                'message' => 'We could not save your appointment. Please try again.',
                'step' => 2,
            ];
        }
    }
}
// :: END SERVICE REQUEST CONTROLLER
