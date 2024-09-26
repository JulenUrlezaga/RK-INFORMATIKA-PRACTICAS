<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../CSS/register.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>USER UPDATE</title>
</head>
<body>
    <div class="container">
        <?php
        require_once '../model/connector.php';

        $database = new Connector();
        $conn = $database->getConnection();
        $userID = $_SESSION['ID'];

        $query = "SELECT user, firstname, surname, passwrd, email FROM users WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$userID]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            echo "User not found.";
            exit;
        }

        ?>
        <div class="d-flex justify-content-center align-items-center vh-100">
        <form method="POST" action="../controller/userupcontroller.php">
            <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg> 
                <h1>BANK</h1>
                <h2>USER UPDATE</h2>
            </div>

            <div class="mb-3">
                <label for="inputUsername" class="form-label">USER: </label>
                <input type="text" class="form-control" id="inputUsername" name="username" value="<?php echo $userData['user']; ?>" required> 
            </div>
            <div class="mb-3">
                <label for="inputFirstname" class="form-label">FIRSTNAME: </label>
                <input type="text" class="form-control" id="inputFirstname" name="firstname" value="<?php echo $userData['firstname']; ?>" required> 
            </div>
            <div class="mb-3">
                <label for="inputSurname" class="form-label">SURNAME: </label>
                <input type="text" class="form-control" id="inputSurname" name="surname" value="<?php echo $userData['surname']; ?>" required> 
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">PASSWORD: </label>
                <p style="color: red">*If you don't want to change the password, leave this box empty</p>
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter new password if you need">
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">EMAIL: </label>
                <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo $userData['email']; ?>" required> 
            </div>
            <div class="buttonslogin">
                <button type="submit" name="submitbtn" class="btn btn-primary">APPLY</button>
                <a href="../view/account.php" class="btn btn-secondary text-white">REMOVE CHANGES</a>
            </div>
        </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>