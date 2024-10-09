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

    public function getCompanyJobs($Queries, $applicantID)
    {
        $query = "
        SELECT j.*, c.company_name, c.company_logo, d.status,d.date_applied
        FROM " . $this->UserTable . " j
        JOIN tblcompany c ON j.company_id = c.id
        LEFT JOIN tblapplication d ON j.id = d.job_id AND d.applicant_ID = :applicantID
        WHERE j.id IN (SELECT DISTINCT job_id FROM tbltags WHERE tags LIKE :Query)
        order by j.id desc,j.datefrom,j.title
        ";

        $stmt = $this->pdo->prepare($query);
        $searchQuery = '%' . $Queries . '%';
        $stmt->bindParam(':Query', $searchQuery, PDO::PARAM_STR);
        $stmt->bindParam(':applicantID', $applicantID, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $baseUrl = 'http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/';
        $CompanyBaseUrl = 'http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/';

        foreach ($results as &$result) {
            $result['pic'] = $baseUrl . $result['pic'];
            $result['company_logo'] = $CompanyBaseUrl . $result['company_name'] . '/' . $result['company_logo'];
        }

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
    $Query = filter_input(INPUT_POST, 'Query', FILTER_SANITIZE_STRING);
    $applicantID = filter_input(INPUT_POST, 'ApplicantID', FILTER_VALIDATE_INT);

    if ($applicantID === null || $applicantID === false) {
        throw new InvalidArgumentException("ApplicantID input is missing or invalid.");
    }

    $companies = $companyRetriever->getCompanyJobs($Query, $applicantID);
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
