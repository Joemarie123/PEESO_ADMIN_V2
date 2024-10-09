<?php
class UserInserter
{
    private $pdo;
    private $UserTable;
    private $loginTable;

    public function __construct($pdo, $UserTable = 'tblpersonal', $loginTable = 'tblLogin')
    {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
        $this->loginTable = $loginTable;
    }

    public function insertUserInfo($UserInfo)
    {
        $query = "INSERT INTO " . $this->UserTable . " 
                  ( Surname, FirstName, MiddleName, Suffix, ContactNo, Email,LoginID) 
                  VALUES (  :Surname, :FirstName, :MiddleName, :Suffix, :ContactNo, :Email,:LoginID)";
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(':Surname', $UserInfo['LastName'], PDO::PARAM_STR);
        $stmt->bindParam(':FirstName', $UserInfo['FirstName'], PDO::PARAM_STR);
        $stmt->bindParam(':MiddleName', $UserInfo['MiddleName'], PDO::PARAM_STR);
        $stmt->bindParam(':Suffix', $UserInfo['Suffix'], PDO::PARAM_STR);
        $stmt->bindParam(':ContactNo', $UserInfo['ContactNo'], PDO::PARAM_STR);
        $stmt->bindParam(':Email', $UserInfo['Email'], PDO::PARAM_STR);
        $stmt->bindParam(':LoginID', $UserInfo['LoginID'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function insertLoginInfo($loginInfo)
    {
        $query = "INSERT INTO " . $this->loginTable . " (Login, Password) VALUES (:Login, :Password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':Login', $loginInfo['Login'], PDO::PARAM_STR);
        $stmt->bindParam(':Password', $loginInfo['Password'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
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
    $UserInserter = new UserInserter($pdo);

    //file uploading-encrypting the name then put to logos
    
        $UserInfo = [
            
            'LastName' => filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING),
            'FirstName' => filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING),
            'MiddleName' => filter_input(INPUT_POST, 'MiddleName', FILTER_SANITIZE_STRING),
            'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
            'ContactNo' => filter_input(INPUT_POST, 'ContactNo', FILTER_SANITIZE_STRING),
            'Email' => filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL),
            'LoginID'=>''
        ];

        $loginInfo = [
            'Login' => filter_input(INPUT_POST, 'Login', FILTER_SANITIZE_STRING),
            'Password' => password_hash(filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT)
        ];

        // Check for missing or invalid inputs
        foreach ($UserInfo as $key => $value) {
            if ($value === null || $value === false) {
                throw new InvalidArgumentException("$key input is missing or invalid.");
            }
        }
        foreach ($loginInfo as $key => $value) {
            if ($value === null || $value === false) {
                throw new InvalidArgumentException("$key input is missing or invalid.");
            }
        }

        // Start transaction
        $pdo->beginTransaction();

        // Insert company info
        $loginId = $UserInserter->insertLoginInfo($loginInfo);
        if ($loginId) {
            // Insert login info

             $UserInfo['LoginID']=$loginId;
            if ($UserInserter->insertUserInfo($UserInfo)) {
                $pdo->commit();
                $results['success'] = true;
                $results['message'] = 'Company and login information inserted successfully.';
                $results['LoginID'] = $loginId;
            } else {
                $pdo->rollBack();
                $results['success'] = false;
                $results['message'] = 'Failed to insert login information.';
            }
        } else {
            $pdo->rollBack();
            $results['success'] = false;
            $results['message'] = 'Failed to insert User information.';
        }
    
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}
echo json_encode($results);
?>