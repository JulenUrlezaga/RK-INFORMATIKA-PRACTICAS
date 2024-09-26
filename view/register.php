<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../CSS/register.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>REGISTER</title>
</head>
<body>
    <div class="container">
        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        require_once '../model/connector.php';
        $database = new Connector();
        $conn = $database->getConnection();

        session_start();


        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }


        ?>

        <div class="d-flex justify-content-center align-items-center vh-100">
            <form method="POST" action="../controller/registercontroller.php">
                <div class="mb-3">
                    <h1>BANK</h1>
                    <h2>REGISTER</h2>
                </div>

                <div class="mb-3">
                    <label for="inputUser" class="form-label">USER: </label>
                    <input type="text" class="form-control" id="inputUser" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="inputFirstn" class="form-label">FIRSTNAME: </label>
                    <input type="text" class="form-control" id="inputFirstn" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label for="inputSurn" class="form-label">SURNAME: </label>
                    <input type="text" class="form-control" id="inputSurn" name="surname" required>
                </div>
                <div class="mb-3">
                    <label for="inputPswd" class="form-label">PASSWORD</label>
                    <input type="password" class="form-control" id="inputPswd" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">EMAIL: </label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <div class="buttonslogin">
                        <button type="submit" name="submitbtn" class="btn btn-primary">REGISTER</button>
                        <a href="../index.php" class="btn btn-info text-white">LOG IN</a>
                </div>
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
