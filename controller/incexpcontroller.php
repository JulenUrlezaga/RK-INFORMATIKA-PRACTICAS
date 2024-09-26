<?php

require_once '../model/loginModel.php';
require_once '../model/connector.php'; 


session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class incexpController {
    private $model;
    private $connector;

    public function __construct() {
        $this->model = new LoginModel();
        $this->connector = new Connector();
    }

    public function handleIncomesExpenses($iduser, $incomes, $expenses) {
        $conn = $this->connector->getConnection();

        // Obtener el balance anterior del usuario
        $sql = "SELECT total FROM accounts WHERE iduser = :IDUser ORDER BY date DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':IDUser', $iduser, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalAnterior = $result ? $result['total'] : 0;

        $nuevoTotal = $totalAnterior + ($incomes - $expenses);

        $date = date('Y-m-d');
        $sql = "INSERT INTO accounts (iduser, date, total, incomes, expenses) VALUES (:IDUser, :date, :total, :incomes, :expenses)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':IDUser', $iduser, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':total', $nuevoTotal, PDO::PARAM_STR);
        $stmt->bindParam(':incomes', $incomes, PDO::PARAM_STR);
        $stmt->bindParam(':expenses', $expenses, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Redirigir después de insertar correctamente
            header("Location: ../view/account.php");
            exit;
        } else {
            echo "Error al intentar insertar los datos.";
        }
    }
}


if (!isset($_SESSION['ID'])) {
    echo "ERROR: ID de usuario no está en la sesión.";
    exit;
}

$iduser = $_SESSION['ID']; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$controller = new incexpController(); 

    if (isset($_POST['income']) && isset($_POST['expense'])) {
    $incomes = $_POST['income'];
    $expenses = $_POST['expense'];

    $controller->handleIncomesExpenses($iduser, $incomes, $expenses);
    }
}
?>
