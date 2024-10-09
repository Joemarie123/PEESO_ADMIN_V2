<?php
class GetApplicant
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    // Method to insert job application data into tblapplication


    // Method to retrieve personal data from tblpersonal based on JobID and ApplicantID
    public function getPersonalData($jobID)
    {
        $sql = "
            SELECT p.* ,a.status,a.job_ID as jobID,b.title,c.status as appointmentstatus,concat('http://10.0.1.26:82/PEESOPORTAL/PDS/CLIENT/Image/',p.pmid,'/',p.pics) as pic
            FROM tblpersonal p
            INNER JOIN tblapplication a ON p.pmid = a.applicant_id
            INNER JOIN tbljobs b on a.Job_ID=b.ID
            LEFT JOIN tblappointment c on p.pmid=c.applicant_id and b.id=c.job_id
            WHERE a.Job_ID = :JobID 
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':JobID', $jobID, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllApplicants($CompanyID)
    {
        $sql = "
            SELECT p.* ,a.status,b.title,b.id as jobID,c.status as appointmentstatus,concat('http://10.0.1.26:82/PEESOPORTAL/PDS/CLIENT/Image/',p.pmid,'/',p.pics) as pic
            FROM tblpersonal p
            INNER JOIN tblapplication a ON p.pmid = a.applicant_id
            INNER JOIN tbljobs b on a.Job_ID=b.ID
            LEFT JOIN tblappointment c on p.pmid=c.applicant_id and b.id=c.job_id
            WHERE b.Company_ID = :CompanyID 
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the ApplyJob class
$job = new GetApplicant($host, $dbname, $username, $password);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['CompanyID'])) {
        $data = [
            'CompanyID' => filter_input(INPUT_POST, 'CompanyID', FILTER_VALIDATE_INT),

        ];
        if ($data['CompanyID']) {
            // First, attempt to add the job application


            // Then, retrieve personal data related to the application
            $personalData = $job->getAllApplicants($data['CompanyID']);



            if (!empty($personalData)) {
                echo json_encode($personalData);
            } else {
                echo "No personal data found for the provided JobID and ApplicantID.";
            }

        } else {
            echo "Error: Invalid input data";
        }


    } else {
        // Retrieve and sanitize POST data
        $data = [
            'JobID' => filter_input(INPUT_POST, 'JobID', FILTER_VALIDATE_INT),
            'CompanyID' => filter_input(INPUT_POST, 'CompanyID', FILTER_VALIDATE_INT),
        ];
        if ($data['JobID']) {
            // First, attempt to add the job application


            // Then, retrieve personal data related to the application
            $personalData = $job->getPersonalData($data['JobID']);



            if (!empty($personalData)) {
                echo json_encode($personalData);
            } else {
                echo "data: false";
            }

        } else {
            echo "Error: Invalid input data";
        }
    }

    // Validate required fields

} else {
    echo "Error: Invalid request method";
}
?>