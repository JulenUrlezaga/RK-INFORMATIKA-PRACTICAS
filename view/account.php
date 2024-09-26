<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../controller/accountcontroller.php';

$userID = $_SESSION['ID'];

$result = $connector->getUserAccounts($userID);

$hasAccount = !empty($result);

$sharedUsers = $connector->getSharedUsers($userID);

$availableUsers = $connector->getAllUsersIncludingAdmins($userID);

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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ACCOUNT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../CSS/account.css" rel="stylesheet">
</head>
<body>

<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown me-2">
                    <a class="dropdown-toggle btn btn-primary" href="#" id="dropdownShareButton" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        SHARE
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownShareButton">
                        <?php if ($filteredUsers): ?>
                            <?php foreach ($filteredUsers as $user): ?>
                                <li><a class="dropdown-item" href="?share_to=<?php echo $user['ID']; ?>"><?php echo $user['firstname']; ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="#">No users available</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item dropdown me-2">
                    <a class="dropdown-toggle btn btn-info" href="#" id="dropdownSharedWithButton" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        SHARED WITH
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownSharedWithButton">
                        <?php if ($sharedUsers): ?>
                            <?php foreach ($sharedUsers as $sharedUser): ?>
                                <li><a class="dropdown-item" href="?unshare_to=<?php echo $sharedUser['shared_user_id']; ?>"><?php echo $sharedUser['firstname']; ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="#">No shared users</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <form method="POST" class="d-inline">
                        <button type="submit" class="btn btn-warning me-2" name="show_shared_tables">SHOW TABLES</button>
                    </form>
                </li>

                <li class="nav-item">
                    <a href="../view/incexp.php" class="btn btn-light me-2">INCOMES / EXPENSES</a>
                </li>

                <li class="nav-item">
                    <a href="../view/userupdate.php" class="btn btn-secondary me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c-.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                        </svg>
                    </a>
                </li>

                <?php if ($hasAccount): ?>
                    <li class="nav-item" id="sendmoney">
                        <a href="../view/sendmoney.php" class="btn btn-success me-2">SEND €</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                    <li class="nav-item">
                        <a href="../view/makeadmin.php" class="btn me-2 adminbutton">MAKE ADMIN</a>
                    </li>
                    <li class="nav-item">
                        <a href="../view/deleteuser.php" class="btn me-2 adminbutton">DELETE USER</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="../view/logout.php" class="btn btn-danger">LOGOUT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<h1 class="banklogo">BANK</h1>

<?php
$adminClass = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] ? 'admin-user' : 'regular-user';
?>

<h1 class="user <?php echo $adminClass; ?>"><?php echo $_SESSION['firstname']?></h1>

<?php if ($hasAccount): ?>
    <table>
        <tr><th>DATE</th><th>TOTAL</th><th class='incomeback'>INCOMES</th><th class='expenseback'>EXPENSES</th></tr>
        <?php
        $total = 0;
        foreach ($result as $row):
        $balance = $total + $row["incomes"] - $row["expenses"];
        ?>
        <tr>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo number_format($total, 2); ?>€</td>
            <td class='income'><?php echo number_format($row["incomes"], 2); ?>€</td>
            <td class='expense'>-<?php echo number_format($row["expenses"], 2); ?>€</td>
        </tr>
        <?php
        $total = $balance;
        endforeach;
        ?>


        <tr>
            <th class='balance'>BALANCE</th>
            <td class='balance'><?php echo number_format($balance, 2); ?>€</td> <!-- Mostrar el total final -->
        </tr>
    </table>
<?php else: ?>
    <p>No accounts found for this user.</p>
<?php endif; ?>


<?php if (isset($_POST['show_shared_tables'])): ?>
    <?php if (empty($sharedWithMeAccounts)): ?>
        <p>Nobody shared tables with you, so sorry.</p>
    <?php else: ?>
        <?php
        $accountsByUser = [];
        foreach ($sharedWithMeAccounts as $sharedRow) {
            if (isset($sharedRow["IDuser"])) {
                $accountsByUser[$sharedRow["IDuser"]][] = $sharedRow;
            } else {
                echo "<p>ERROR: IDuser not found</p>";
            }
        }

        if (isset($conn)):
            foreach ($accountsByUser as $userId => $accounts):
                $userQuery = "SELECT firstname, surname FROM users WHERE ID = ?";
                $stmt = $conn->prepare($userQuery);
                $stmt->execute([$userId]);
                $user = $stmt->fetch();
                ?>
                <br>
                <h3>Table of: <b><?php echo $user['firstname'] . ' ' . $user['surname']; ?></b></h3>
                <table>
                    <tr><th>DATE</th><th>TOTAL</th><th class='incomeback'>INCOMES</th><th class='expenseback'>EXPENSES</th></tr>

                    <?php
                    $sharedTotal = 100; // Total inicial

                    foreach ($accounts as $sharedRow):

                        $sharedBalance = $sharedTotal;

                        $sharedTotal += $sharedRow["incomes"] - $sharedRow["expenses"];
                        ?>
                        <tr>
                            <td><?php echo $sharedRow["date"]; ?></td>
                            <td><?php echo number_format($sharedBalance, 2); ?>€</td>
                            <td class='income'><?php echo number_format($sharedRow["incomes"], 2); ?>€</td>
                            <td class='expense'>-<?php echo number_format($sharedRow["expenses"], 2); ?>€</td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <th class='balance'>BALANCE</th>
                        <td class='balance'><?php echo number_format($sharedTotal, 2); ?>€</td> <!-- Mostrar el balance final -->
                    </tr>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
