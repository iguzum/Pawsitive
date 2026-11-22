<?php
namespace App\Controller;

use App\Model\Adoption_Application;
use App\Model\Service_Request;

// :: START ADOPTION APPLICATION CONTROLLER
// :: START ADOPTION STATUS CONTROLLER OVERRIDE
class Adoption_Application_Controller extends Abstract_Status_Controller
    // :: END ADOPTION STATUS CONTROLLER OVERRIDE
{
    private Adoption_Application $application;
    private Service_Request $serviceRequest;
    private Service_Request_Controller $serviceRequestController;

    public function __construct()
    {
        $this->application = new Adoption_Application();
        $this->serviceRequest = new Service_Request();
        $this->serviceRequestController = new Service_Request_Controller($this->serviceRequest);
    }

    public function handlePageRequest(
        int $accountId,
        string $requestMethod,
        array $post,
        array &$session
    ): array {
        $state = [
            'applicant_profile' => $this->application->getApplicantProfile($accountId),
            'form_values' => [],
            'form_error' => '',
            'show_modal' => false,
            'form_step' => 1,
            'success_message' => (string) ($session['adoption_application_success'] ?? ''),
            'redirect_to' => null,
        ];

        unset($session['adoption_application_success']);

        if ($requestMethod !== 'POST' || ($post['form_action'] ?? '') !== 'submit_adoption') {
            return $state;
        }

        $state['form_values'] = $post;
        $state['show_modal'] = true;
        $state['form_step'] = 2;

        $validation = $this->validateApplication($post);

        if ($validation['error'] !== '') {
            $state['form_error'] = $validation['error'];
            return $state;
        }

        try {
            $this->application->submitApplication($accountId, $validation['data']);
            $session['adoption_application_success'] = 'Your adoption application has been submitted.';
            $state['redirect_to'] = 'index.php#pets';
        } catch (\Exception $error) {
            $state['form_error'] = 'We could not submit your application. Please try again.';
        }

        return $state;
    }

    // :: START CUSTOMER SCHEDULE AND STAFF DASHBOARD
    public function getCustomerSchedule(int $accountId): array
    {
        return [
            'adoption_applications' => $this->application->getForApplicant($accountId),
            'service_requests' => $this->serviceRequest->getForAccount($accountId),
        ];
    }

    public function getStaffDashboard(): array
    {
        return [
            'adoption_applications' => $this->application->getAllApplications(),
            'service_requests' => $this->serviceRequest->getAllRequests(),
        ];
    }

    // :: START ADOPTION STATUS UPDATE OVERRIDE
    public function updateStatus(int $recordId, string $status): bool
    {
        return $this->application->updateStatus($recordId, $status);
    }
    // :: END ADOPTION STATUS UPDATE OVERRIDE

    public function updateStaffStatus(array $post): string
    {
        $recordType = (string) ($post['record_type'] ?? '');
        $recordId = filter_var($post['record_id'] ?? null, FILTER_VALIDATE_INT);
        $status = (string) ($post['status'] ?? '');

        if (
            $recordId === false
            || $recordId < 1
            || !in_array($status, ['Pending', 'Approved', 'Rejected'], true)
        ) {
            return 'Choose a valid status.';
        }

        // :: START POLYMORPHIC STATUS CONTROLLER
        $statusController = match ($recordType) {
            'adoption' => $this,
            'service' => $this->serviceRequestController,
            default => null,
        };

        if (!($statusController instanceof Abstract_Status_Controller)) {
            return 'Choose a valid request.';
        }

        $updated = $statusController->updateStatus($recordId, $status);
        // :: END POLYMORPHIC STATUS CONTROLLER

        return $updated ? 'Status updated.' : 'Could not update the status.';
    }

    // :: START STAFF RECORD REMOVAL
    public function removeStaffRecord(array $post): string
    {
        $recordId = filter_var($post['record_id'] ?? null, FILTER_VALIDATE_INT);

        if ($recordId === false || $recordId < 1) {
            return 'Choose a valid record to remove.';
        }

        $formAction = (string) ($post['form_action'] ?? '');

        if ($formAction === 'delete_adoption') {
            $removed = $this->application->deleteApplication($recordId);
            return $removed ? 'Adoption application removed.' : 'Could not remove the adoption application.';
        }

        if ($formAction === 'delete_service_request') {
            $removed = $this->serviceRequest->deleteRequest($recordId);
            return $removed ? 'Care appointment removed.' : 'Could not remove the care appointment.';
        }

        return 'Choose a valid record to remove.';
    }
    // :: END STAFF RECORD REMOVAL
    // :: END CUSTOMER SCHEDULE AND STAFF DASHBOARD

    private function validateApplication(array $post): array
    {
        $petId = filter_var($post['adoption_pet_id'] ?? null, FILTER_VALIDATE_INT);
        $age = filter_var($post['age'] ?? null, FILTER_VALIDATE_INT);
        $householdMembers = filter_var($post['household_members'] ?? null, FILTER_VALIDATE_INT);
        $monthlyIncome = trim((string) ($post['monthly_income'] ?? ''));
        $firstName = trim((string) ($post['first_name'] ?? ''));
        $lastName = trim((string) ($post['last_name'] ?? ''));
        $address = trim((string) ($post['address'] ?? ''));
        $occupation = trim((string) ($post['occupation'] ?? ''));
        $reasonForAdoption = trim((string) ($post['reason_for_adoption'] ?? ''));
        $isCommitted = (string) ($post['is_committed'] ?? '');

        $validIncome = is_numeric($monthlyIncome)
            && (float) $monthlyIncome >= 0
            && (float) $monthlyIncome <= 99999999.99;

        if (
            !$petId || $petId < 1
            || $firstName === '' || strlen($firstName) > 50
            || $lastName === '' || strlen($lastName) > 50
            || $age === false || $age < 0 || $age > 255
            || $address === '' || strlen($address) > 255
            || !$validIncome
            || $occupation === '' || strlen($occupation) > 100
            || $householdMembers === false || $householdMembers < 1 || $householdMembers > 255
            || $reasonForAdoption === ''
            || !in_array($isCommitted, ['Y', 'N'], true)
        ) {
            return [
                'error' => 'Please complete all fields with valid information.',
                'data' => [],
            ];
        }

        return [
            'error' => '',
            'data' => [
                'pet_id' => $petId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'age' => $age,
                'address' => $address,
                'monthly_income' => $monthlyIncome,
                'occupation' => $occupation,
                'household_members' => $householdMembers,
                'reason_for_adoption' => $reasonForAdoption,
                'is_committed' => $isCommitted,
            ],
        ];
    }
}
// :: END ADOPTION APPLICATION CONTROLLER
