<?php
session_start();


if (!isset($_SESSION['ID'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../controller/accountcontroller.php';

$userID = $_SESSION['ID'];

if (isset($_GET['make_admin'])) {
    $adminUserId = $_GET['make_admin'];
    $insertStmt = $connector->getConnection()->prepare("INSERT INTO adminusers (ID, username) SELECT ID, firstname FROM users WHERE ID = ?");

    if ($insertStmt->execute([$adminUserId])) {
        $_SESSION['successadmin'] = "The user became ADMIN successfully";
    } else {
        $_SESSION['erroradmin'] = "There were some problems while trying to make this user an ADMIN, try again later";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


$allUsers = $connector->getAllUsers();
$adminUsers = $connector->getAdminUsers();


$filteredUsers = array_filter($allUsers, function($user) use ($adminUsers) {
    foreach ($adminUsers as $adminUser) {
        if ($user['ID'] == $adminUser['ID']) {
            return false;
        }
    }
    return true;
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ADMIN MAKER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../CSS/register.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<form>
<div class="container mt-5">
    <h1 class="text-center">BANK</h1>
    <h2 class="text-center adminh2">MAKE ADMIN</h2>

    <?php
    if (isset($_SESSION['successadmin'])) {
        echo "<div class='alert alert-success text-center' role='alert'>" . $_SESSION['successadmin'] . "</div>";
        unset($_SESSION['successadmin']);
    } elseif (isset($_SESSION['erroradmin'])) {
        echo "<div class='alert alert-danger text-center' role='alert'>" . $_SESSION['erroradmin'] . "</div>";
        unset($_SESSION['erroradmin']);
    }
    ?>

    <div class="list-group mb-4">
        <?php if ($filteredUsers): ?>
            <?php foreach ($filteredUsers as $user): ?>
                <a href="?make_admin=<?php echo $user['ID']; ?>" class="list-group-item list-group-item-action">
                    <?php echo $user['firstname']; ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">NO USERS TO MAKE THEM ADMINS</p>
        <?php endif; ?>
    </div>


    <div class="text-center">
        <a href="../view/account.php" class="btn btn-secondary">BACK TO ACCOUNT</a>
    </div>
</div>
</form>
</body>
</html>
