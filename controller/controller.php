<?php

require_once '../model/loginModel.php';
require_once '../model/connector.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class MainController {
    private $model;
    private $connector;

    public function __construct() {
        $this->model = new LoginModel();
        $this->connector = new Connector();
    }

    public function handleShare($userID, $shareToID) {
        $conn = $this->connector->getConnection();

        if (!$conn) {
            throw new Exception("FAILED CONNECTION.");
        }

        if ($shareToID) {
            $checkSQL = "SELECT COUNT(*) FROM sharedaccounts WHERE IDuser = :IDuser AND IDshared = :IDshared";
            $checkStmt = $conn->prepare($checkSQL);
            $checkStmt->bindParam(':IDuser', $userID, PDO::PARAM_INT);
            $checkStmt->bindParam(':IDshared', $shareToID, PDO::PARAM_INT);
            $checkStmt->execute();
            $exists = $checkStmt->fetchColumn();

            if ($exists == 0) {
                $sql = "INSERT INTO sharedaccounts (IDuser, IDshared) VALUES (:IDuser, :IDshared)";
                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':IDuser', $userID, PDO::PARAM_INT);
                    $stmt->bindParam(':IDshared', $shareToID, PDO::PARAM_INT);
                    $stmt->execute();

                    $userSQL = "SELECT firstname FROM users WHERE ID = :ID";
                    $userStmt = $conn->prepare($userSQL);
                    $userStmt->bindParam(':ID', $shareToID, PDO::PARAM_INT);
                    $userStmt->execute();
                    $sharedUser = $userStmt->fetch(PDO::FETCH_ASSOC);
                    $sharedUserName = $sharedUser['firstname'];

                    $_SESSION['success'] = "Shared correctly with user $sharedUserName";
                } catch (PDOException $e) {
                    $_SESSION['error'] = "ERROR sharing account: " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Already shared with this user.";
            }
        }
        header("Location: ../view/account.php");
        exit;
    }

    public function handleUnshare($userID, $UnshareToID) {
        $conn = $this->connector->getConnection();

        if (!$conn) {
            throw new Exception("FAILED CONNECTION.");
        }
        if ($UnshareToID) {
            $checkSQL = "SELECT COUNT(*) FROM sharedaccounts WHERE IDuser = :IDuser AND IDshared = :IDshared";
            $checkStmt = $conn->prepare($checkSQL);
            $checkStmt->bindParam(':IDuser', $userID, PDO::PARAM_INT);
            $checkStmt->bindParam(':IDshared', $UnshareToID, PDO::PARAM_INT);
            $checkStmt->execute();
            $exists = $checkStmt->fetchColumn();

            if ($exists > 0) {
                $sql = "DELETE FROM sharedaccounts WHERE IDuser = :IDuser AND IDshared = :IDshared";
                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':IDuser', $userID, PDO::PARAM_INT);
                    $stmt->bindParam(':IDshared', $UnshareToID, PDO::PARAM_INT);
                    $stmt->execute();

                    $userSQL = "SELECT firstname FROM users WHERE ID = :ID";
                    $userStmt = $conn->prepare($userSQL);
                    $userStmt->bindParam(':ID', $UnshareToID, PDO::PARAM_INT);
                    $userStmt->execute();
                    $UnsharedUser = $userStmt->fetch(PDO::FETCH_ASSOC);
                    $UnsharedUserName = $UnsharedUser['firstname'];

                    $_SESSION['success'] = "Unshared correctly with user $UnsharedUserName";
                } catch (PDOException $e) {
                    $_SESSION['error'] = "ERROR unsharing account: " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Account not shared with this user.";
            }
        }

        header("Location: ../view/account.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new MainController();

    if (isset($_POST['share_to'])) {
        $shareToID = intval($_POST['share_to']);
        $userID = $_SESSION['ID'];
        $controller->handleShare($userID, $shareToID);
    } elseif (isset($_POST['unshare_to'])) {
        $UnshareToID = intval($_POST['unshare_to']);
        $userID = $_SESSION['ID'];
        $controller->handleUnshare($userID, $UnshareToID);
    }
}
?>
