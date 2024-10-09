<?php
class Appointment {
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

    public function GetMyAppointment($data) {
        $sql = "SELECT 
        tblappointment.*,tbljobs.title,tbljobs.salary,tbljobs.description,tblcompany.company_name,tblcompany.company_address,tblcompany.ContactNo,concat('http://10.0.1.26:82/PEESOPORTAL/REGISTRATION/ADMIN/Logos/',tblcompany.company_name,'/',tblcompany.company_logo) as Company_logo,
        concat('http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/',tbljobs.pic) as pic
            
        FROM 
            tblappointment
        inner join
            tbljobs
        on
            tblappointment.job_ID=tbljobs.id
        inner join
            tblcompany
        on
            tbljobs.Company_ID=tblcompany.id
        
        
        WHERE 
           applicant_ID=:ApplicantID
        
        ";

        $stmt = $this->pdo->prepare($sql);

         $stmt->execute([
           
            ':ApplicantID' => $data['ApplicantID'],
            
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Appointment class
$appointment = new Appointment($host, $dbname, $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize POST data
    $data = [
        
        'ApplicantID' => filter_input(INPUT_POST, 'ApplicantID', FILTER_VALIDATE_INT),
        
    ];

    // Attempt to create the appointment
    $appointments=$appointment->GetMyAppointment($data);
    // if ($appointments) {
        // echo "Appointment successfully fetched!";
        echo json_encode($appointments);
    // } else {
    //     echo "Error: Unable to fetch appointment.";
    // }
}
?>
