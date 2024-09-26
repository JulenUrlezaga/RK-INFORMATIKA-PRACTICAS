<?php
session_start();
require_once '../model/connector.php';
$database = new Connector();
$conn = $database->getConnection();

if (isset($_POST['userID'])) {
    $selectedUserID = $_POST['userID'];

    $stmt = $conn->prepare("SELECT firstname FROM users WHERE ID = ?");
    $stmt->execute([$selectedUserID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $conn->beginTransaction();

        try {

            $deleteSharedAccountsStmt = $conn->prepare("DELETE FROM shared_accounts WHERE user_id = ?");

            $deleteUserStmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
            $deleteUserStmt->execute([$selectedUserID]);

            $conn->commit();

            $_SESSION['success'] = $user['firstname'] . " has been successfully deleted.";
            header("Location: ../view/deleteuser.php");
            exit;
        } catch (Exception $e) {

            $conn->rollBack();
            $_SESSION['error'] = "Error deleting user: " . $e->getMessage();
            header("Location: ../view/deleteuser.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: ../view/deleteuser.php");
        exit;
    }
} else {
    $_SESSION['error'] = "No user selected.";
    header("Location: ../view/deleteuser.php");
    exit;
}
