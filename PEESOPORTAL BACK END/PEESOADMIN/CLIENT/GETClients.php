<?php
class CompanyRetriever {
    private $pdo;
    private $UserTable;

    public function __construct($pdo, $UserTable = 'tblpersonal') {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
    }

    public function getCompaniesByLoginID() {
        $query = "SELECT * FROM " . $this->UserTable;
        $stmt = $this->pdo->prepare($query);
       
        $stmt->execute();
        
        return $stmt->fetchAll();
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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    $companyRetriever = new CompanyRetriever($pdo);

    // Retrieve the LoginID from the form data
   
    $companies = $companyRetriever->getCompaniesByLoginID();
    $results['success'] = true;
    $results['data'] = $companies;
} catch (PDOException $e) {
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}

echo json_encode($results);
?>
