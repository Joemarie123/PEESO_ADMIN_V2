<?php
class CompanyRetriever {
    private $pdo;
    private $UserTable;

    public function __construct($pdo, $UserTable = 'tblpersonal') {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
    }

    public function getCompaniesByLoginID($loginID) {
        $query = "SELECT *,concat('http://10.0.1.26:82/PEESOPORTAL/PDS/CLIENT/Image/',tblpersonal.pmid,'/',tblpersonal.pics) as pic FROM " . $this->UserTable . " WHERE LoginID = :loginID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':loginID', $loginID, PDO::PARAM_INT);
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
    $loginID = filter_input(INPUT_POST, 'LoginID', FILTER_VALIDATE_INT);
    if ($loginID === null || $loginID === false) {
        throw new InvalidArgumentException("LoginID input is missing or invalid.");
    }

    $companies = $companyRetriever->getCompaniesByLoginID($loginID);
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
