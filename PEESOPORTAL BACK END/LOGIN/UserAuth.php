<?php
class UserAuth {
    private $pdo;

    public function __construct($dsn, $db_username, $db_password) {
        try {
            $this->pdo = new PDO($dsn, $db_username, $db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function authenticate($username, $password) {
        $query = "SELECT password,ID FROM tblLogin WHERE login = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // $hashpassword=$user['password'];
        // $verify=password_verify($password, $hashpassword);
        // echo $username . " - " . $password . " -_" . $user['password'] . " -- " . $ver;
        if ($user && password_verify($password, $user['password'])) {
            return $user['ID'];
        } else {
            return false;
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }
}
?>
