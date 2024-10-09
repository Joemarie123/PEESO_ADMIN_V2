<?php
class Company {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function updateCompanyRecord($data) {
        $sql = "UPDATE tblcompany SET Company_name = :Company_name, Company_address = :Company_address, 
                LastName = :LastName, FirstName = :FirstName, MiddleName = :MiddleName, 
                Suffix = :Suffix, ContactNo = :ContactNo, Email = :Email, 
                 WHERE ID = :ID";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':Company_name' => $data['Company_name'],
            ':Company_address' => $data['Company_address'],
            ':LastName' => $data['LastName'],
            ':FirstName' => $data['FirstName'],
            ':MiddleName' => $data['MiddleName'],
            ':Suffix' => $data['Suffix'],
            ':ContactNo' => $data['ContactNo'],
            ':Email' => $data['Email'],
            
            
            ':ID' => $data['ID']
        ]);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Company class
$company = new Company($host, $dbname, $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize POST data
    $data = [
        'ID' => filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT),
        'Company_name' => filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING),
        'Company_address' => filter_input(INPUT_POST, 'Company_address', FILTER_SANITIZE_STRING),
        'LastName' => filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING),
        'FirstName' => filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING),
        'MiddleName' => filter_input(INPUT_POST, 'MiddleName', FILTER_SANITIZE_STRING),
        'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
        'ContactNo' => filter_input(INPUT_POST, 'ContactNo', FILTER_SANITIZE_STRING),
        'Email' => filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL),
        
       
    ];

    // Validate required fields
    if ($data['ID'] === false) {
        echo "Error: Invalid ID.";
        exit();
    }

    // Attempt to update the company record
    if ($company->updateCompanyRecord($data)) {
        echo "Company record successfully updated!";
    } else {
        echo "Error: Unable to update company record.";
    }
}
?>
