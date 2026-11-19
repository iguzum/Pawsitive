<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Authentication_Controller;

// :: START LOGOUT CONTROLLER DISPATCH
$auth = new Authentication_Controller();
$auth->logout();
// :: END LOGOUT CONTROLLER DISPATCH