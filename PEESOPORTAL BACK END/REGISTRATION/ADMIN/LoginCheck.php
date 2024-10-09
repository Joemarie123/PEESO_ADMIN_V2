<?php
class LoginChecker {
    private $pdo;
    private $loginTable;
    private $companyTable;

    public function __construct($pdo, $loginTable = 'tblLogin', $companyTable = 'tblcompany') {
        $this->pdo = $pdo;
        $this->loginTable = $loginTable;
        $this->companyTable = $companyTable;
    }

    public function isLoginRegistered($login) {
        $query = "SELECT COUNT(*) FROM " . $this->loginTable . " WHERE login = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function isCompanyInfoRegistered($companyInfo) {
        $query = "SELECT * FROM " . $this->companyTable . " 
                  WHERE 
                  Email = :email";
        $stmt = $this->pdo->prepare($query);
        // $stmt->bindParam(':companyName', $companyInfo['Company_name'], PDO::PARAM_STR);
        // $stmt->bindParam(':lastName', $companyInfo['LastName'], PDO::PARAM_STR);
        // $stmt->bindParam(':firstName', $companyInfo['FirstName'], PDO::PARAM_STR);
        // $stmt->bindParam(':middleName', $companyInfo['MiddleName'], PDO::PARAM_STR);
        // $stmt->bindParam(':suffix', $companyInfo['Suffix'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $companyInfo['Email'], PDO::PARAM_STR);
        $stmt->execute();
        
        // if( $stmt->rowCount()>0){
        //     return $stmt->fetchall(PDO::FETCH_ASSOC);
        // }
        return $stmt->fetchColumn() > 0;
    }
}

// Usage example
try {
    $results = [];
    $dsn = 'mysql:host=localhost;dbname=PEESO';
    $username = 'root';
    $password = '';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    $loginChecker = new LoginChecker($pdo);

    $login = filter_input(INPUT_POST, 'Login', FILTER_SANITIZE_STRING);
    if ($login === null) {
        throw new InvalidArgumentException("Login input is missing or invalid.");
    }
    
    $companyInfo = [
        // 'Company_name' => filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING),
        // 'LastName' => filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING),
        // 'FirstName' => filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING),
        // 'MiddleName' => filter_input(INPUT_POST, 'MiddleName', FILTER_SANITIZE_STRING),
        // 'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
        'Email' => filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL)
    ];

    // Check for missing or invalid inputs
    foreach ($companyInfo as $key => $value) {
        if ($value === null) {
            throw new InvalidArgumentException("$key input is missing or invalid.");
        }
    }

    if ($loginChecker->isLoginRegistered($login)) {
        $results['login_duplicate'] = true;
    } else {
        $results['login_duplicate'] = false;
    }
    
    if ($loginChecker->isCompanyInfoRegistered($companyInfo)) {
        $results['email_duplicate'] = true;

    } else {
        $results['email_duplicate'] = false;
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
echo json_encode($results);
?>
