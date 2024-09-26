<?php

require_once '../model/loginModel.php';
require_once '../model/connector.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class sendmoneyController {
    private $model;
    private $connector;

    public function __construct() {
        $this->model = new LoginModel();
        $this->connector = new Connector();
    }

    public function handleSendMoney($iduser, $recipientID, $amount) {
        $conn = $this->connector->getConnection();
        $date = date('Y-m-d');

        try {

            $sql = "SELECT total FROM accounts WHERE iduser = :IDUser ORDER BY date DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':IDUser', $iduser, PDO::PARAM_INT);
            $stmt->execute();
            $resultSender = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalSender = $resultSender ? $resultSender['total'] : 0;


            $nuevoTotalSender = $totalSender - $amount;
            $incomesSender = 0;
            $expensesSender = $amount;
            $sql = "INSERT INTO accounts (iduser, date, total, incomes, expenses) VALUES (:IDUser, :date, :total, :incomes, :expenses)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':IDUser', $iduser, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':total', $nuevoTotalSender, PDO::PARAM_STR);
            $stmt->bindParam(':incomes', $incomesSender, PDO::PARAM_STR);
            $stmt->bindParam(':expenses', $expensesSender, PDO::PARAM_STR);
            $stmt->execute();

            // Obtener el balance anterior del destinatario
            $sql = "SELECT total FROM accounts WHERE iduser = :recipientID ORDER BY date DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':recipientID', $recipientID, PDO::PARAM_INT);
            $stmt->execute();
            $resultRecipient = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalRecipient = $resultRecipient ? $resultRecipient['total'] : 0;


            $nuevoTotalRecipient = $totalRecipient + $amount;
            $incomesRecipient = $amount;
            $expensesRecipient = 0;

            $sql = "INSERT INTO accounts (iduser, date, total, incomes, expenses) VALUES (:IDRecipient, :date, :total, :incomes, :expenses)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':IDRecipient', $recipientID, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':total', $nuevoTotalRecipient, PDO::PARAM_STR);
            $stmt->bindParam(':incomes', $incomesRecipient, PDO::PARAM_STR);
            $stmt->bindParam(':expenses', $expensesRecipient, PDO::PARAM_STR);
            $stmt->execute();

            // Redirigir al finalizar la transacción
            header("Location: ../view/account.php");
            exit;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if (!isset($_SESSION['ID'])) {
    echo "ERROR: ID de usuario no está en la sesión.";
    exit;
}

$iduser = $_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new sendmoneyController();

    // Verificar si se envió el monto y el usuario
    if (isset($_POST['sendmoney']) && isset($_POST['user_id'])) {
        $amount = $_POST['sendmoney'];
        $recipientID = $_POST['user_id'];

        $controller->handleSendMoney($iduser, $recipientID, $amount);
    }
}
