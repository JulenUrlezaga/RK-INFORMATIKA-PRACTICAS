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
        $insertStmt = $conn->prepare("INSERT INTO adminusers (ID, username) VALUES (?, ?)");
        $insertStmt->execute([$selectedUserID, $user['firstname']]);

        $_SESSION['success'] = $user['firstname'] . " became a new admin.";
        header("Location: ../view/makeadmin.php");
        exit;
    } else {
        $_SESSION['error'] = "Error picking the user.";
        header("Location: ../view/makeadmin.php");
        exit;
    }
} else {
    $_SESSION['error'] = "No user selected.";
    header("Location: ../view/makeadmin.php");
    exit;
}
