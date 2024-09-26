<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../controller/accountcontroller.php';

$userID = $_SESSION['ID'];

// Comprobar si se ha solicitado convertir a un usuario en administrador
if (isset($_GET['make_admin'])) {
    $adminUserId = $_GET['make_admin'];
    $insertStmt = $connector->getConnection()->prepare("INSERT INTO adminusers (ID, username) SELECT ID, firstname FROM users WHERE ID = ?");

    if ($insertStmt->execute([$adminUserId])) {
        $_SESSION['success'] = "El usuario ha sido convertido en administrador.";
    } else {
        $_SESSION['error'] = "Error al convertir al usuario en administrador.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Comprobar si se ha solicitado eliminar un usuario
if (isset($_GET['delete_user'])) {
    $selectedUserID = $_GET['delete_user'];

    // Obtener el nombre del usuario para el mensaje
    $stmt = $connector->getConnection()->prepare("SELECT firstname FROM users WHERE ID = ?");
    $stmt->execute([$selectedUserID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Comenzar la transacción
        $connector->getConnection()->beginTransaction();

        try {
            // Borrar los datos del usuario en shared_accounts
            $deleteSharedAccountsStmt = $connector->getConnection()->prepare("DELETE FROM shared_accounts WHERE user_id = ?");
            $deleteSharedAccountsStmt->execute([$selectedUserID]);

            // Borrar el usuario de la tabla users
            $deleteUserStmt = $connector->getConnection()->prepare("DELETE FROM users WHERE ID = ?");
            $deleteUserStmt->execute([$selectedUserID]);

            // Confirmar la transacción
            $connector->getConnection()->commit();

            // Redireccionar y mostrar el mensaje de éxito
            $_SESSION['success'] = $user['firstname'] . " ha sido eliminado correctamente.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            // Si hay un error, hacer rollback de la transacción
            $connector->getConnection()->rollBack();
            $_SESSION['error'] = "Error al eliminar el usuario: " . $e->getMessage();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
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
<form method="POST" action="">
    <div class="container mt-5">
        <h1 class="text-center">BANK</h1>
        <h2 class="text-center text-danger">DELETE USER</h2>

        <?php
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success text-center' role='alert'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger text-center' role='alert'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
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
                <p class="text-center">NO HAY USUARIOS PARA ELIMINAR</p>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <h4 class="text-danger">IF YOU CLICK AN USER, YOU GONNA DELETE IT</h4>
            <p>CAN'T REMOVE THE CHANGE</p>
        </div>

        <div class="text-center">
            <a href="../view/account.php" class="btn btn-secondary">BACK TO ACCOUNT</a>
        </div>
    </div>
</form>
</body>
</html>
