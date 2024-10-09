<?php
class UpdateApplicant {
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

    public function UpdateApplicantStatus($data) {
        $sql = "UPDATE tblapplication set status=:status
                where  job_ID=:JobID and applicant_ID= :ApplicantID";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':JobID' => $data['JobID'],
            ':ApplicantID' => $data['ApplicantID'],
           ':status'=>$data['status']
        ]);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Job class
$Update = new UpdateApplicant($host, $dbname, $username, $password);


$results=[];
//file uploading-encrypting the name then put to logos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

// Retrieve and sanitize POST data
$data = [
    'JobID' => filter_input(INPUT_POST, 'JobID', FILTER_VALIDATE_INT),
    'ApplicantID' => filter_input(INPUT_POST, 'ApplicantID', FILTER_VALIDATE_INT),
    
    'status' => filter_input(INPUT_POST, 'Status', FILTER_SANITIZE_STRING),
];

// Check if required fields are present and valid
// if ($data['Company_ID'] && $data['Title'] && $data['pic'] && $data['Salary'] !== false && $data['DateFrom'] && $data['DateTo'] && $data['Description'] && $data['NumHours'] !== false && $data['Type'] && $data['WorkPlace'] && $data['VacantCount'] !== false && $data['EducationLevel'] && $data['Course'] && $data['WorkExperience'] !== false && $data['License']) {
    // Attempt to add the job
    if ($Update->UpdateApplicantStatus($data)) {
        echo "Job Application sent successfully";
    } else {
        echo "Error: Unable to apply job";
    }
// } else {
//     echo "Error: Invalid input data";
}
?>
