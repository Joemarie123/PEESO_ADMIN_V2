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

    public function createAppointment($data) {
        $sql = "INSERT INTO tblappointment (Job_ID, Applicant_ID, Appointment_date, Appointment_time)
                VALUES (:JobID, :ApplicantID, :AppointmentDate, :AppointmentTime)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':JobID' => $data['JobID'],
            ':ApplicantID' => $data['ApplicantID'],
            ':AppointmentDate' => $data['AppointmentDate'],
            ':AppointmentTime' => $data['AppointmentTime']
        ]);
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
        'JobID' => filter_input(INPUT_POST, 'JobID', FILTER_VALIDATE_INT),
        'ApplicantID' => filter_input(INPUT_POST, 'ApplicantID', FILTER_VALIDATE_INT),
        'AppointmentDate' => filter_input(INPUT_POST, 'Appointment_date', FILTER_SANITIZE_STRING),
        'AppointmentTime' => filter_input(INPUT_POST, 'Appointment_time', FILTER_SANITIZE_STRING),
    ];

    // Attempt to create the appointment
    if ($appointment->createAppointment($data)) {
        echo "Appointment successfully created!";
    } else {
        echo "Error: Unable to create appointment.";
    }
}
?>
