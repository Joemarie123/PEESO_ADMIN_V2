<?php
class ClientJobsRetriever
{
    private $pdo;
    private $UserTable;

    public function __construct($pdo, $UserTable = 'tbljobs')
    {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
    }

    public function getCompanyLogos()
    {
        $query = "
        SELECT ID,concat('http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/',company_name,'/',company_logo) as Logo from tblcompany where company_logo<>''
        ";

        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

       

        return $results;
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
    $companyRetriever = new ClientJobsRetriever($pdo);

    // Retrieve the Query and ApplicantID from the form data
   

    $companies = $companyRetriever->getCompanyLogos();
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
