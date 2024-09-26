<?php
require_once 'connector.php';

class AccountModel {
    private $conn;

    public function __construct() {
        $connector = new Connector();
        $this->conn = $connector->getConnection();
    }

    public function doesAccountExist($userId) {

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM accounts WHERE IDuser = ?");
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}
?>