<?php
class Education {
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

    public function createEducationRecord($data) {
        $sql = "INSERT INTO xeducation (Education, School, Codes, Degree, NumUnits, YearLevel, DateAttend, Honors, Graduated, Orders, ControlNo)
                VALUES (:Education, :School, :Codes, :Degree, :NumUnits, :YearLevel, :DateAttend, :Honors, :Graduated, :Orders, :ControlNo)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':Education' => $data['Education'],
            ':School' => $data['School'],
            ':Codes' => $data['Codes'],
            ':Degree' => $data['Degree'],
            ':NumUnits' => $data['NumUnits'],
            ':YearLevel' => $data['YearLevel'],
            ':DateAttend' => $data['DateAttend'],
            ':Honors' => $data['Honors'],
            ':Graduated' => $data['Graduated'],
            ':Orders' => $data['Orders'],
            ':ControlNo' => $data['ControlNo']
        ]);
    }

    public function getEducationRecords($controlNo = null) {
        if ($controlNo) {
            $sql = "SELECT * FROM xeducation WHERE ControlNo = :ControlNo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':ControlNo' => $controlNo]);
        } else {
            $sql = "SELECT * FROM xeducation";
            $stmt = $this->pdo->query($sql);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEducationRecord($data) {
        $sql = "UPDATE xeducation SET Education = :Education, School = :School, Codes = :Codes, Degree = :Degree, 
                NumUnits = :NumUnits, YearLevel = :YearLevel, DateAttend = :DateAttend, Honors = :Honors, 
                Graduated = :Graduated, Orders = :Orders WHERE PMID = :PMID";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':Education' => $data['Education'],
            ':School' => $data['School'],
            ':Codes' => $data['Codes'],
            ':Degree' => $data['Degree'],
            ':NumUnits' => $data['NumUnits'],
            ':YearLevel' => $data['YearLevel'],
            ':DateAttend' => $data['DateAttend'],
            ':Honors' => $data['Honors'],
            ':Graduated' => $data['Graduated'],
            ':Orders' => $data['Orders'],
            ':PMID' => $data['PMID']
        ]);
    }

    public function deleteEducationRecord($pmid) {
        $sql = "DELETE FROM xeducation WHERE PMID = :PMID";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':PMID' => $pmid]);
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Education class
$education = new Education($host, $dbname, $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    
    switch ($action) {
        case 'add':
            // Retrieve and sanitize POST data
            $data = [
                'Education' => filter_input(INPUT_POST, 'Education', FILTER_SANITIZE_STRING),
                'School' => filter_input(INPUT_POST, 'School', FILTER_SANITIZE_STRING),
                'Codes' => filter_input(INPUT_POST, 'Codes', FILTER_SANITIZE_STRING),
                'Degree' => filter_input(INPUT_POST, 'Degree', FILTER_SANITIZE_STRING),
                'NumUnits' => filter_input(INPUT_POST, 'NumUnits', FILTER_VALIDATE_INT),
                'YearLevel' => filter_input(INPUT_POST, 'YearLevel', FILTER_VALIDATE_INT),
                'DateAttend' => filter_input(INPUT_POST, 'DateAttend', FILTER_SANITIZE_SPECIAL_CHARS),
                'Honors' => filter_input(INPUT_POST, 'Honors', FILTER_SANITIZE_STRING),
                'Graduated' => filter_input(INPUT_POST, 'Graduated', FILTER_SANITIZE_STRING),
                'Orders' => filter_input(INPUT_POST, 'Orders', FILTER_SANITIZE_STRING),
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_VALIDATE_INT)
            ];

            // Validate and format the date
            if (DateTime::createFromFormat('Y-m-d', $data['DateAttend']) === false) {
                echo "Error: Invalid date format. Please use YYYY-MM-DD.";
                exit();
            }

            // Attempt to create the education record
            if ($education->createEducationRecord($data)) {
                echo "Education record successfully created!";
            } else {
                echo "Error: Unable to create education record.";
            }
            break;

        case 'view':
            $controlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_VALIDATE_INT);
            $records = $education->getEducationRecords($controlNo);
            echo json_encode($records);
            break;

        case 'edit':
            $data = [
                'PMID' => filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT),
                'Education' => filter_input(INPUT_POST, 'Education', FILTER_SANITIZE_STRING),
                'School' => filter_input(INPUT_POST, 'School', FILTER_SANITIZE_STRING),
                'Codes' => filter_input(INPUT_POST, 'Codes', FILTER_SANITIZE_STRING),
                'Degree' => filter_input(INPUT_POST, 'Degree', FILTER_SANITIZE_STRING),
                'NumUnits' => filter_input(INPUT_POST, 'NumUnits', FILTER_VALIDATE_INT),
                'YearLevel' => filter_input(INPUT_POST, 'YearLevel', FILTER_VALIDATE_INT),
                'DateAttend' => filter_input(INPUT_POST, 'DateAttend', FILTER_SANITIZE_SPECIAL_CHARS),
                'Honors' => filter_input(INPUT_POST, 'Honors', FILTER_SANITIZE_STRING),
                'Graduated' => filter_input(INPUT_POST, 'Graduated', FILTER_SANITIZE_STRING),
                'Orders' => filter_input(INPUT_POST, 'Orders', FILTER_SANITIZE_STRING),
            ];

            if (DateTime::createFromFormat('Y-m-d', $data['DateAttend']) === false) {
                echo "Error: Invalid date format. Please use YYYY-MM-DD.";
                exit();
            }

            if ($education->updateEducationRecord($data)) {
                echo "Education record successfully updated!";
            } else {
                echo "Error: Unable to update education record.";
            }
            break;

        case 'delete':
            $pmid = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
            if ($education->deleteEducationRecord($pmid)) {
                echo "Education record successfully deleted!";
            } else {
                echo "Error: Unable to delete education record.";
            }
            break;

        default:
            echo "Error: Invalid action.";
            break;
    }
}
?>
