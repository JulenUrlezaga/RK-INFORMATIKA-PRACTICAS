<?php
require_once 'connector.php';

class LoginModel {
    private $conn;

    public function __construct() {
        $database = new Connector(); 
        $this->conn = $database->getConnection();
    }

    public function login($username, $password) {
        // Primera consulta para verificar usuario y contraseña
        $query = "SELECT * FROM users WHERE user = ? AND passwrd = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, MD5($password)]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar si el usuario es administrador
            $adminQuery = "SELECT COUNT(*) FROM adminusers WHERE ID = ?";
            $adminStmt = $this->conn->prepare($adminQuery);
            $adminStmt->execute([$user['ID']]);
            $isAdmin = $adminStmt->fetchColumn() > 0;

            $_SESSION['ID'] = $user['ID'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['isAdmin'] = $isAdmin; // Esta línea establece la variable isAdmin

            // Debugging
            echo "DEBUG: isAdmin = " . ($isAdmin ? "true" : "false") . "<br>";

            return $user;
        }

        return null;
    }



}
?>