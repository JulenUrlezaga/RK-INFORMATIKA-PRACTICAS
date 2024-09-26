<?php
class Connector {
    private $host = "localhost";
    private $db = "bank5";
    private $user = "root";
    private $pass = "";

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function isAdmin($userID) {
        $query = "SELECT COUNT(*) FROM adminusers WHERE ID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchColumn() > 0;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getUserAccounts($userID) {
        $query = "SELECT date, total, incomes, expenses FROM accounts WHERE IDuser = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOtherUsers($userID) {

        $query = "SELECT u.ID, u.firstname
              FROM users u 
              LEFT JOIN adminusers a ON u.ID = a.ID
              WHERE a.ID IS NULL AND u.ID != ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getSharedUsers($userID) {
        $query = "SELECT sharedaccounts.IDshared AS shared_user_id, users.firstname 
                  FROM sharedaccounts 
                  INNER JOIN users ON sharedaccounts.IDshared = users.ID 
                  WHERE sharedaccounts.IDuser = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSharedWithMeAccounts($userID) {
        $query = "SELECT a.*, s.IDuser AS IDuser 
                  FROM accounts AS a 
                  JOIN sharedaccounts AS s ON a.IDuser = s.IDuser 
                  WHERE s.IDshared = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $query = "SELECT ID, firstname FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminUsers() {
        $query = "SELECT ID, username FROM adminusers";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersIncludingAdmins($userID) {
        $stmt = $this->conn->prepare("
        SELECT u.ID, u.firstname
        FROM users u
        LEFT JOIN adminusers a ON u.ID = a.ID
        WHERE u.ID != ?
        ORDER BY u.ID;
    ");
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
