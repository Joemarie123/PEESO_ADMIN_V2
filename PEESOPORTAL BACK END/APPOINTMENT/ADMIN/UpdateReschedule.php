<?php
class Appointment
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

    public function SetAppointment($data)
    {
        if ($data['Action'] == 'NEW SCHEDULE') {
            // $sql="INSERT into tblappointmenthistory (Appointment_ID,Appointment_Date,Appointment_Time) Select ID,Appointment_Date,Appointment_Time from tblappointment where id=:AppointmentID";
            // $stmt = $this->pdo->prepare($sql);

            // $stmt->execute([

            // ':AppointmentID' => $data['AppointmentID'],

            // ]);
            $sql = "UPDATE tblReschedule set active=0 where appointment_id=:AppointmentID";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([

                ':AppointmentID' => $data['AppointmentID'],

            ]);
            // $sql = "INSERT into tblReschedule (Appointment_ID,Appointment_date,Appointment_time,Active) values(:AppointmentID,:Appointment_date,:Appointment_time,'1')";
            // $stmt = $this->pdo->prepare($sql);

            // $stmt->execute([

            //     ':AppointmentID' => $data['AppointmentID'],
            //     ':Appointment_date' => $data['Appointment_date'],
            //     ':Appointment_time' => $data['Appointment_time'],


            // ]);
            $sql = "UPDATE tblappointment set Appointment_date=:Appointment_date , Appointment_time=:Appointment_time,status='NEW SCHEDULE' where id=:AppointmentID";




            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([

                ':AppointmentID' => $data['AppointmentID'],
                
                ':Appointment_date' => $data['Appointment_date'],
                ':Appointment_time' => $data['Appointment_time'],

            ]);
        }
        else if ($data['Action'] == 'ACCEPT') {
            // $sql="INSERT into tblappointmenthistory (Appointment_ID,Appointment_Date,Appointment_Time) Select ID,Appointment_Date,Appointment_Time from tblappointment where id=:AppointmentID";
            // $stmt = $this->pdo->prepare($sql);

            // $stmt->execute([

            // ':AppointmentID' => $data['AppointmentID'],

            // ]);
            //     $sql="UPDATE tblReschedule set active=0 where appointment_id=:AppointmentID";
            //     $stmt = $this->pdo->prepare($sql);

            //     $stmt->execute([

            //     ':AppointmentID' => $data['AppointmentID'],

            //     ]);
            //     $sql="INSERT into tblReschedule (Appointment_ID,Appointment_date,Appointment_time,Active) values(:AppointmentID,:Appointment_date,:Appointment_time,'1')";
            //     $stmt = $this->pdo->prepare($sql);

            //     $stmt->execute([

            //      ':AppointmentID' => $data['AppointmentID'],
            //     ':Appointment_date'=>$data['Appointment_date'],
            // ':Appointment_time'=>$data['Appointment_time'],


            //     ]);
            $sql = "UPDATE tblappointment set Appointment_date=:Appointment_date , Appointment_time=:Appointment_time,status=:status where id=:AppointmentID";

                


            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([

                ':AppointmentID' => $data['AppointmentID'],
                ':status' => $data['status'],
                
                ':Appointment_date' => $data['Appointment_date'],
                ':Appointment_time' => $data['Appointment_time'],

            ]);
        } else {
            $sql = "UPDATE tblappointment set status=:status where id=:AppointmentID";




            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([

                ':AppointmentID' => $data['AppointmentID'],
                ':status' => $data['status'],
               
            ]);
        }


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

        'AppointmentID' => filter_input(INPUT_POST, 'AppointmentID', FILTER_VALIDATE_INT),
        'Action' => filter_input(INPUT_POST, 'Action', FILTER_SANITIZE_STRING),
        'Appointment_date' => filter_input(INPUT_POST, 'Appointment_date', FILTER_SANITIZE_STRING),
        'Appointment_time' => filter_input(INPUT_POST, 'Appointment_time', FILTER_SANITIZE_STRING),
        'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING),
        
    ];


    // Attempt to create the appointment
    $appointments = $appointment->SetAppointment($data);
    // if ($appointments) {
    // echo "Appointment successfully fetched!";
    echo json_encode($appointments);
    // } else {
    //     echo "Error: Unable to fetch appointment.";
    // }
}
?>