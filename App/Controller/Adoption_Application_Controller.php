<?php
namespace App\Controller;

use App\Model\Adoption_Application;
use App\Model\Service_Request;

// :: START ADOPTION APPLICATION CONTROLLER
class Adoption_Application_Controller
{
    private Adoption_Application $application;
    private Service_Request $serviceRequest;

    public function __construct()
    {
        $this->application = new Adoption_Application();
        $this->serviceRequest = new Service_Request();
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

        if ($recordType === 'adoption') {
            $updated = $this->application->updateStatus($recordId, $status);
        } elseif ($recordType === 'service') {
            $updated = $this->serviceRequest->updateStatus($recordId, $status);
        } else {
            return 'Choose a valid request.';
        }

        return $updated ? 'Status updated.' : 'Could not update the status.';
    }
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
