<?php
namespace App\Controller;
// :: START AUTHENTICATION MODEL IMPORT FIX
use App\Model\Authentication;
// :: END AUTHENTICATION MODEL IMPORT FIX

class Authentication_Controller
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Authentication();
    }

    public function login()
    {
        // :: START ACCOUNT LOGIN AND ROLE HANDLING
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = $this->auth->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'] ?? $user['account_id'] ?? $user['email'];
            $role = strtolower(trim((string) ($user['account_role'] ?? 'customer')));
            $_SESSION['user_role'] = $role !== '' ? $role : 'customer';

            if ($_SESSION['user_role'] === 'admin') {
                // :: START ADMIN DASHBOARD ROUTE
                header('Location: ./admin/dashboard.php');
                // :: END ADMIN DASHBOARD ROUTE
            } elseif ($_SESSION['user_role'] === 'staff') {
                // :: START STAFF DASHBOARD ROUTE
                header('Location: ./staff/dashboard.php');
                // :: END STAFF DASHBOARD ROUTE
            } else {
                header('Location: index.php');
            }
            exit();

        } else {
            return "Wrong email or password";
        }
        // :: END ACCOUNT LOGIN AND ROLE HANDLING
    }

    public function createAccount(): ?string
    {
        // :: START CUSTOMER REGISTRATION
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Enter a valid email address.';
        }

        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters.';
        }

        if ($password !== $confirmPassword) {
            return 'Passwords do not match.';
        }

        if ($this->auth->getUserByEmail($email) !== null) {
            return 'An account with this email already exists.';
        }

        $this->auth->createAccount($email, $password);
        return 'Registration successful. You can now sign in.';
        // :: END CUSTOMER REGISTRATION
    }

    // :: START LOGOUT CONTROLLER ACTION
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $cookieParams = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $cookieParams['path'],
                $cookieParams['domain'],
                $cookieParams['secure'],
                $cookieParams['httponly']
            );
        }

        session_destroy();

        header('Location: login.php');
        exit();
    }
    // :: END LOGOUT CONTROLLER ACTION
    public function isLogin(): bool
    {
        // :: START SESSION INITIALIZATION
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION['user_id']);
        // :: END SESSION INITIALIZATION
    }
}
?>