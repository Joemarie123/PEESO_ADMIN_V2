<?php
class LoginChecker {
    private $pdo;
    private $loginTable;
    private $UserTable;

    public function __construct($pdo, $loginTable = 'tblLogin', $UserTable = 'tblpersonal') {
        $this->pdo = $pdo;
        $this->loginTable = $loginTable;
        $this->UserTable = $UserTable;
    }
    public function isLoginRegistered($login) {
        $query = "SELECT COUNT(*) FROM " . $this->loginTable . " WHERE login = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function isUserRegistered($Userinfo) {
        $query = "SELECT * FROM " . $this->UserTable . " WHERE Email = :email;";
        $stmt = $this->pdo->prepare($query);
        
        // $stmt->bindParam(':surname', $Userinfo['Surname'], PDO::PARAM_STR);
        // $stmt->bindParam(':firstName', $Userinfo['FirstName'], PDO::PARAM_STR);
        // $stmt->bindParam(':middleName', $Userinfo['MiddleName'], PDO::PARAM_STR);
        // $stmt->bindParam(':suffix', $Userinfo['Suffix'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $Userinfo['Email'], PDO::PARAM_STR);
        $stmt->execute();
        
        if( $stmt->rowCount()>0){
            return $stmt->fetchall(PDO::FETCH_ASSOC);
        }
        // return $stmt->fetchColumn() > 0;
    }
}

// Usage example
try {
    $results=[];
    $dsn = 'mysql:host=localhost;dbname=PEESO';
    $username = 'root';
    $password = '';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    $loginChecker = new LoginChecker($pdo);
    
    $login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
    if ($login === null) {
        throw new InvalidArgumentException("Login input is missing or invalid.");
    }
    
    $UserInfo = [
        
        // 'Surname' => filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING),
        // 'FirstName' => filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING),
        // 'MiddleName' => filter_input(INPUT_POST, 'MiddleName', FILTER_SANITIZE_STRING),
        // 'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
        'Email' => filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL)
    ];

    // Check for missing or invalid inputs
    foreach ($UserInfo as $key => $value) {
        if ($value === null) {
            throw new InvalidArgumentException("$key input is missing or invalid.");
        }
    }

    if ($loginChecker->isLoginRegistered($login)) {
        $results['login_duplicate'] = true;
    } else {
        $results['login_duplicate'] = false;
    }
    
    if ($loginChecker->isUserRegistered($UserInfo)) {
        $results['Email_duplicate'] = true;

    } else {
        $results['Email_duplicate'] = false;
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
echo json_encode($results);
?>
