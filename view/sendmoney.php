<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../CSS/register.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>INCOME/EXPENSE</title>
</head>
<body>
<div class="container">
    <?php
    session_start();

    if (!isset($_SESSION['ID'])) {
        header("Location: ../index.php");
        exit;
    }

    require_once '../model/connector.php';
    require_once '../controller/controller.php';

    $connector = new Connector();
    $conn = $connector->getConnection();

    if (!$conn) {
        die("FAILED CONNECTION.");
    }

    $userID = $_SESSION['ID'];
    $result = $connector->getUserAccounts($userID);
    $users = $connector->getOtherUsers($userID);

    /*Compartir*/
    if (isset($_GET['share_to'])) {
        $shareToID = intval($_GET['share_to']);

        if ($shareToID) {
            $controller = new MainController();
            $controller->handleShare($userID, $shareToID);
        }
    }

    /*Dejar de compartir*/
    if (isset($_GET['unshare_to'])) {
        $UnshareToID = intval($_GET['unshare_to']);

        if ($UnshareToID) {
            $controller = new MainController();
            $controller->handleUnshare($userID, $UnshareToID);
        }
    }

    $sharedUsers = $connector->getSharedUsers($userID);
    $sharedWithList = "";

    if ($sharedUsers) {
        foreach ($sharedUsers as $sharedUser) {
            $sharedWithList .= "<li><a class='dropdown-item' href='#'>{$sharedUser['firstname']}</a></li>";
        }
    }

    $availableUsers = $connector->getOtherUsers($userID);
    $sharedUsers = $connector->getSharedUsers($userID);

    $filteredUsers = array_filter($availableUsers, function($user) use ($sharedUsers) {
        foreach ($sharedUsers as $sharedUser) {

            if ($user['ID'] == $sharedUser['shared_user_id']) {
                return false;
            }
        }
        return true;
    });

    $sharedWithMeAccounts = $connector->getSharedWithMeAccounts($userID);
    ?>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <form method="POST" action="../controller/sendmoneycontroller.php">
            <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="40" fill="currentColor" class="bi bi-currency-euro" viewBox="0 0 16 16">
                    <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="40" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                </svg>
                <h1>BANK</h1>
                <h2>SEND MONEY</h2>
            </div>

            <div class="mb-3">
                <label for="inputSendmoney" class="form-label">SEND: </label>
                <input type="number" class="form-control" id="inputSendmoney" name="sendmoney" value="0.00" step="0.01" min="0" required>
            </div>

            <div class="mb-3">
                <label for="selectUser" class="form-label">Select User: </label>
                <select class="form-select" id="selectUser" name="user_id" required>
                    <option value="" selected disabled>Choose a user</option>
                    <?php foreach ($availableUsers as $user): ?>
                        <option value="<?php echo $user['ID']; ?>"><?php echo $user['firstname']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="buttonslogin">
                <button type="submit" name="submitbuttn" class="btn btn-primary">APPLY</button>
                <a href="../view/account.php" class="btn btn-secondary text-white">REMOVE CHANGES</a>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
