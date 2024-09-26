<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="CSS/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>LOGIN</title>
</head>
<body>
    <div class="container">
        <?php
        
        require_once 'model/connector.php';
        $database = new Connector();
        $conn = $database->getConnection();

        session_start();

        $max_attempts = 3;
        $attempts_left = $max_attempts;

        if (isset($_SESSION['login_blocked']) && time() >= $_SESSION['login_blocked']) {
            
            unset($_SESSION['login_blocked']);
            $_SESSION['login_attempts'] = 0;
        }
        if (isset($_SESSION['login_attempts'])) {
            $attempts_left = $max_attempts - $_SESSION['login_attempts'];
        }
        
        ?>

        <div class="d-flex justify-content-center align-items-center vh-100">
            <form method="POST" action="./controller/logincontroller.php">
                <div class="mb-3 text-center">
                    <h1>BANK</h1>
                </div>
                <?php
                if ($conn) {
                    echo "<div class='connection-message text-success'>CONNECTED</div>";
                } else {
                    echo "<div class='connection-message text-danger'>CANT CONNECT</div>";
                }

                if (isset($_SESSION['login_blocked']) && time() < $_SESSION['login_blocked']) {
                    $remaining_time = $_SESSION['login_blocked'] - time();
                    echo "<div class='alert alert-danger text-center' role='alert'>Try again in $remaining_time seconds.</div>";
             
                    echo "<meta http-equiv='refresh' content='$remaining_time;URL=index.php'>";
                }
                ?>
                <div class="mb-3">
                    <label for="inputUser" class="form-label">USER</label>
                    <input type="text" class="form-control" id="inputUser" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="inputPswd" class="form-label">PASSWORD</label>
                    <input type="password" class="form-control" id="inputPswd" name="password" required>
                </div>

            
                <?php if (!isset($_SESSION['login_blocked']) || time() >= $_SESSION['login_blocked']) : ?>
                <div class="mb-3 text-center">
                    <p class='alert alert-secondary text-center' role='alert'>YOU HAVE <?php echo "<b>$attempts_left</b>" ?> TRIES LEFT</p>
                </div>
                <?php endif; ?>

             
                <?php if (!isset($_SESSION['login_blocked']) || time() >= $_SESSION['login_blocked']) : ?>
                    <div class="buttonslogin">
                        <button type="submit" name="submitbtn" class="btn btn-primary">LOG IN</button>
                        <a href="./view/register.php" class="btn btn-info text-white">SIGN IN</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

