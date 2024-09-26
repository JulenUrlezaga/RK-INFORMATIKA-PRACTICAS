<?php

require_once '../model/loginModel.php';
require_once '../model/connector.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class registerController {
    private $model;
    private $connector;

    public function __construct() {
        $this->model = new LoginModel();
        $this->connector = new Connector(); 
    }


    public function handleRegister($username, $password, $firstname, $surname, $email) {

        
        $conn = $this->connector->getConnection();
    
        $checkSQL = "SELECT COUNT(*) FROM users WHERE user = :username";
        $stmt = $conn->prepare($checkSQL);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();
    
        if ($userExists > 0) {
            $_SESSION['error'] = "Username already taken.";
            header("Location: ../view/register.php");
            exit;
        }
    
        $hashedPassword = md5($password);
    
        $sql = "INSERT INTO users (user, firstname, surname, passwrd, email) VALUES (:username, :firstname, :surname, :password, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
       
        if ($stmt->execute()) {
            header("Location: ../index.php"); 
            exit;
        } else {
            header("Location: ../view/register.php");
            exit;
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new registerController();
    
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['surname'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];

        $controller->handleRegister($username, $password, $firstname, $surname, $email);

    }
}
?>
