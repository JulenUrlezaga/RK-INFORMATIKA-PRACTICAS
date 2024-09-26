<?php

require_once '../model/loginModel.php';
require_once '../model/connector.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LoginController {
    private $model;
    private $connector;

    public function __construct() {
        $this->model = new LoginModel();
        $this->connector = new Connector(); 
    }

    public function handleLogin($username, $password) {
        if (isset($_SESSION['login_blocked']) && time() < $_SESSION['login_blocked']) {
            $remaining_time = $_SESSION['login_blocked'] - time();
            $_SESSION['error'] = "Try again in $remaining_time seconds.";
            header("Location: ../index.php");
            exit;
        }

        $user = $this->model->login($username, $password);

        if ($user) {

            unset($_SESSION['login_attempts']);
            unset($_SESSION['login_blocked']);

            $_SESSION['user'] = $user['user'];
            $_SESSION['iduser'] = $user['ID'];


            header("Location: ../view/account.php");
            exit;
        }

        else {
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 0;
            }
            $_SESSION['login_attempts'] += 1;

            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['login_blocked'] = time() + 60;
                $remaining_time = $_SESSION['login_blocked'] - time();
            }

            header("Location: ../index.php");
            exit;
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new LoginController();
    
    }if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $controller->handleLogin($username, $password);
 } 

?>