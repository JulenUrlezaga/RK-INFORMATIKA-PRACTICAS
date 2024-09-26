<?php
require_once '../model/connector.php';
session_start();

try {
    $database = new Connector();
    $conn = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userID = $_SESSION['ID'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $surname = $_POST['surname'];

        $conn->beginTransaction();

        $sql = "UPDATE users SET user = :username, email = :email WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $userID);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar los datos del usuario.");
        }

        if (!empty($_POST['password'])) {
            $newPassword = md5($_POST['password']);

            $sql = "UPDATE users SET passwrd = :password WHERE ID = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':id', $userID);

            if (!$stmt->execute()) {
                throw new Exception("ERROR");
            }
        }

        $conn->commit();

        $_SESSION['success'] = "USER UPDATED SUCCESSFULLY";
        header('Location: ../view/account.php');
        exit;
    }
} catch (Exception $e) {
    $conn->rollBack();
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: ../view/account.php');
    exit;
}
?>
