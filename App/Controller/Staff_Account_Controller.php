<?php
namespace App\Controller;

use App\Model\Staff_Account;
use Exception;

// :: START STAFF ACCOUNT CONTROLLER
class Staff_Account_Controller
{
    private Staff_Account $staff;

    public function __construct()
    {
        $this->staff = new Staff_Account();
    }

    public function getAllStaff(): array
    {
        return $this->staff->getAllStaff();
    }

    public function createStaff(array $form): array
    {
        $staff = $this->validateStaff($form, true);
        if ($staff['error'] !== '') {
            return ['success' => false, 'message' => $staff['error']];
        }

        if ($this->staff->emailExists($staff['data']['email'])) {
            return ['success' => false, 'message' => 'That email is already in use.'];
        }

        try {
            $this->staff->createStaff($staff['data']);
            return ['success' => true, 'message' => 'Staff account added.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not add the staff account.'];
        }
    }

    public function updateStaff(array $form): array
    {
        $accountId = filter_var($form['account_id'] ?? null, FILTER_VALIDATE_INT);
        if ($accountId === false || $accountId < 1) {
            return ['success' => false, 'message' => 'Choose a valid staff account.'];
        }

        $staff = $this->validateStaff($form, false);
        if ($staff['error'] !== '') {
            return ['success' => false, 'message' => $staff['error']];
        }

        if ($this->staff->emailExists($staff['data']['email'], $accountId)) {
            return ['success' => false, 'message' => 'That email is already in use.'];
        }

        try {
            $updated = $this->staff->updateStaff($accountId, $staff['data']);
            return $updated
                ? ['success' => true, 'message' => 'Staff account updated.']
                : ['success' => false, 'message' => 'No staff account was changed.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not update the staff account.'];
        }
    }

    public function deleteStaff(int $accountId): array
    {
        if ($accountId < 1) {
            return ['success' => false, 'message' => 'Choose a valid staff account.'];
        }

        try {
            $deleted = $this->staff->deleteStaff($accountId);
            return $deleted
                ? ['success' => true, 'message' => 'Staff account removed.']
                : ['success' => false, 'message' => 'Staff account was not found.'];
        } catch (Exception $error) {
            return ['success' => false, 'message' => 'Could not remove the staff account.'];
        }
    }

    private function validateStaff(array $form, bool $passwordRequired): array
    {
        $firstName = trim((string) ($form['first_name'] ?? ''));
        $lastName = trim((string) ($form['last_name'] ?? ''));
        $email = trim((string) ($form['email'] ?? ''));
        $password = (string) ($form['password'] ?? '');

        if (
            $firstName === '' || strlen($firstName) > 50
            || $lastName === '' || strlen($lastName) > 50
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 150
            || ($passwordRequired && strlen($password) < 8)
            || (!$passwordRequired && $password !== '' && strlen($password) < 8)
        ) {
            return ['error' => 'Enter valid staff details. Passwords must be at least 8 characters.'];
        }

        return [
            'error' => '',
            'data' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
            ],
        ];
    }
}
// :: END STAFF ACCOUNT CONTROLLER
