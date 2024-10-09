<?php
class Experience {
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

    // Add new experience record
    public function createExperienceRecord($data) {
        $sql = "INSERT INTO xexperience (CONTROLNO, WFrom, WTo, WPosition, WCompany, WSalary, WGrade, Status, WGov)
                VALUES (:CONTROLNO, :WFrom, :WTo, :WPosition, :WCompany, :WSalary, :WGrade, :Status, :WGov)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':CONTROLNO' => $data['CONTROLNO'],
            ':WFrom' => $data['WFrom'],
            ':WTo' => $data['WTo'],
            ':WPosition' => $data['WPosition'],
            ':WCompany' => $data['WCompany'],
            ':WSalary' => $data['WSalary'],
            ':WGrade' => $data['WGrade'],
            ':Status' => $data['Status'],
            ':WGov' => $data['WGov']
        ]);
    }

    // View experience records by CONTROLNO
    public function getExperienceRecords($controlNo) {
        $sql = "SELECT * FROM xexperience WHERE CONTROLNO = :CONTROLNO";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':CONTROLNO' => $controlNo]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update experience record by ID
    public function updateExperienceRecord($data) {
        $sql = "UPDATE xexperience SET CONTROLNO = :CONTROLNO, WFrom = :WFrom, WTo = :WTo, WPosition = :WPosition, 
                WCompany = :WCompany, WSalary = :WSalary, WGrade = :WGrade, Status = :Status, WGov = :WGov
                WHERE ID = :ID";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':CONTROLNO' => $data['CONTROLNO'],
            ':WFrom' => $data['WFrom'],
            ':WTo' => $data['WTo'],
            ':WPosition' => $data['WPosition'],
            ':WCompany' => $data['WCompany'],
            ':WSalary' => $data['WSalary'],
            ':WGrade' => $data['WGrade'],
            ':Status' => $data['Status'],
            ':WGov' => $data['WGov'],
            ':ID' => $data['ID']
        ]);
    }

    // Delete experience record by ID
    public function deleteExperienceRecord($id) {
        $sql = "DELETE FROM xexperience WHERE ID = :ID";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':ID' => $id]);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Experience class
$experience = new Experience($host, $dbname, $username, $password);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            // Add experience record
            $data = [
                'CONTROLNO' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'WFrom' => filter_input(INPUT_POST, 'WFrom', FILTER_SANITIZE_STRING),
                'WTo' => filter_input(INPUT_POST, 'WTo', FILTER_SANITIZE_STRING),
                'WPosition' => filter_input(INPUT_POST, 'WPosition', FILTER_SANITIZE_STRING),
                'WCompany' => filter_input(INPUT_POST, 'WCompany', FILTER_SANITIZE_STRING),
                'WSalary' => filter_input(INPUT_POST, 'WSalary', FILTER_VALIDATE_FLOAT),
                'WGrade' => filter_input(INPUT_POST, 'WGrade', FILTER_SANITIZE_STRING),
                'Status' => filter_input(INPUT_POST, 'Status', FILTER_SANITIZE_STRING),
                'WGov' => filter_input(INPUT_POST, 'WGov', FILTER_SANITIZE_STRING),
            ];

            if ($experience->createExperienceRecord($data)) {
                echo "Experience record successfully created!";
            } else {
                echo "Error: Unable to create experience record.";
            }
            break;

        case 'edit':
            // Edit experience record
            $data = [
                'ID' => filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT),
                'CONTROLNO' => filter_input(INPUT_POST, 'CONTROLNO', FILTER_SANITIZE_STRING),
                'WFrom' => filter_input(INPUT_POST, 'WFrom', FILTER_SANITIZE_STRING),
                'WTo' => filter_input(INPUT_POST, 'WTo', FILTER_SANITIZE_STRING),
                'WPosition' => filter_input(INPUT_POST, 'WPosition', FILTER_SANITIZE_STRING),
                'WCompany' => filter_input(INPUT_POST, 'WCompany', FILTER_SANITIZE_STRING),
                'WSalary' => filter_input(INPUT_POST, 'WSalary', FILTER_VALIDATE_FLOAT),
                'WGrade' => filter_input(INPUT_POST, 'WGrade', FILTER_SANITIZE_STRING),
                'Status' => filter_input(INPUT_POST, 'Status', FILTER_SANITIZE_STRING),
                'WGov' => filter_input(INPUT_POST, 'WGov', FILTER_SANITIZE_STRING),
            ];

            if ($experience->updateExperienceRecord($data)) {
                echo "Experience record successfully updated!";
            } else {
                echo "Error: Unable to update experience record.";
            }
            break;

        case 'delete':
            // Delete experience record
            $id = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);

            if ($experience->deleteExperienceRecord($id)) {
                echo "Experience record successfully deleted!";
            } else {
                echo "Error: Unable to delete experience record.";
            }
            break;

        case 'view':
            // View experience records by CONTROLNO
            $controlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);

            $records = $experience->getExperienceRecords($controlNo);
            echo json_encode($records);
            break;

        default:
            echo "Error: Invalid action.";
            break;
    }
}
?>
