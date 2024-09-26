<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../model/connector.php';
require_once '../controller/controller.php';
require_once '../model/accountModel.php';

$connector = new Connector();
$conn = $connector->getConnection();

if (!$conn) {
    die("FAILED CONNECTION.");
}

$userID = $_SESSION['ID'];

$accountModel = new AccountModel();
$accountExists = $accountModel->doesAccountExist($userID);

if (!$accountExists) {
    echo "<div class='alert alert-warning'>Firstly create an account</div>";
}

$result = $connector->getUserAccounts($userID);
$users = $connector->getOtherUsers($userID);

if (isset($_GET['share_to'])) {
    $shareToID = intval($_GET['share_to']);
    if ($shareToID) {
        $controller = new MainController();
        $controller->handleShare($userID, $shareToID);
    }
}

if (isset($_GET['unshare_to'])) {
    $unshareToID = intval($_GET['unshare_to']);
    if ($unshareToID) {
        $controller = new MainController();
        $controller->handleUnshare($userID, $unshareToID);
    }
}

$sharedUsers = $connector->getSharedUsers($userID);
$sharedWithList = "";

if ($sharedUsers) {
    foreach ($sharedUsers as $sharedUser) {
        $sharedWithList .= "<li><a class='dropdown-item' href='#'>{$sharedUser['firstname']}</a></li>";
    }
}

$sharedWithMeAccounts = $connector->getSharedWithMeAccounts($userID);

$availableUsers = $connector->getOtherUsers($userID);
$filteredUsers = array_filter($availableUsers, function($user) use ($sharedUsers) {
    foreach ($sharedUsers as $sharedUser) {
        if ($user['ID'] == $sharedUser['shared_user_id']) {
            return false;
        }
    }
    return true;
});

$hasAccount = !empty($result);

?>
