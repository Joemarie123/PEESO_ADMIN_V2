<?php
class CompanyInserter
{
    private $pdo;
    private $companyTable;
    private $loginTable;

    public function __construct($pdo, $companyTable = 'tblcompany', $loginTable = 'tblLogin')
    {
        $this->pdo = $pdo;
        $this->companyTable = $companyTable;
        $this->loginTable = $loginTable;
    }

    public function insertCompanyInfo($companyInfo)
    {
        $query = "INSERT INTO " . $this->companyTable . " 
                  (Company_name,Company_address, Company_logo, LastName, FirstName, MiddleName, Suffix, ContactNo, Email,loginid) 
                  VALUES (:Company_name,:Company_address,:Company_logo,  :LastName, :FirstName, :MiddleName, :Suffix, :ContactNo, :Email,:loginid)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':Company_name', $companyInfo['Company_name'], PDO::PARAM_STR);
        $stmt->bindParam(':Company_address', $companyInfo['Company_address'], PDO::PARAM_STR);
        $stmt->bindParam(':Company_logo', $companyInfo['Company_logo'], PDO::PARAM_STR);
        $stmt->bindParam(':LastName', $companyInfo['LastName'], PDO::PARAM_STR);
        $stmt->bindParam(':FirstName', $companyInfo['FirstName'], PDO::PARAM_STR);
        $stmt->bindParam(':MiddleName', $companyInfo['MiddleName'], PDO::PARAM_STR);
        $stmt->bindParam(':Suffix', $companyInfo['Suffix'], PDO::PARAM_STR);
        $stmt->bindParam(':ContactNo', $companyInfo['ContactNo'], PDO::PARAM_STR);
        $stmt->bindParam(':Email', $companyInfo['Email'], PDO::PARAM_STR);
        $stmt->bindParam(':loginid', $companyInfo['LoginID'], PDO::PARAM_STR);

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
    $companyInserter = new CompanyInserter($pdo);

    //file uploading-encrypting the name then put to logos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $companyname=filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING);
                $uploadDir = 'C:/xampp/htdocs/PEESOPORTAL/REGISTRATION/ADMIN/Logos/' . $companyname . '/';
                if(file_exists($uploadDir)){
                    $bytes = random_bytes(10);
                    $randomString = bin2hex($bytes);
                    $originalFileName = $_FILES['file']['name'];
                    $originalExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                    $newFileName = $randomString . '.' . $originalExtension;
    
                    $uploadFile = $uploadDir . $newFileName;
    
    
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                }else{
                    mkdir($uploadDir);
                    // $uploadDir = 'C:/xampp/htdocs/PEESOPORTAL/REGISTRATION/ADMIN/Logos/';
                    $bytes = random_bytes(10);
                    $randomString = bin2hex($bytes);
                    $originalFileName = $_FILES['file']['name'];
                    $originalExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                    $newFileName = $randomString . '.' . $originalExtension;
    
                    $uploadFile = $uploadDir . $newFileName;
    
    
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                }
                $results['image'] = true;
            }
        } else {
            $results['image'] = false;
            $newFileName = '';
        }
        $companyInfo = [
            'Company_name' => filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING),
            'Company_address' => filter_input(INPUT_POST, 'Company_address', FILTER_SANITIZE_STRING),
            'Company_logo' => $newFileName,
            'LoginID'=>'',
            'LastName' => filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING),
            'FirstName' => filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING),
            'MiddleName' => filter_input(INPUT_POST, 'MiddleName', FILTER_SANITIZE_STRING),
            'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
            'ContactNo' => filter_input(INPUT_POST, 'ContactNo', FILTER_SANITIZE_STRING),
            'Email' => filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL)
        ];

        $loginInfo = [
            'Login' => filter_input(INPUT_POST, 'Login', FILTER_SANITIZE_STRING),
            'Password' => password_hash(filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT)
        ];

        // Check for missing or invalid inputs
        foreach ($companyInfo as $key => $value) {
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
        $loginId = $companyInserter->insertLoginInfo($loginInfo);
        // Insert company info
        if ($loginId) {
            // Insert login info

             $companyInfo['LoginID']=$loginId;
            if ($companyInserter->insertCompanyInfo($companyInfo)) {
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
            $results['message'] = 'Failed to insert company information.';
        }
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