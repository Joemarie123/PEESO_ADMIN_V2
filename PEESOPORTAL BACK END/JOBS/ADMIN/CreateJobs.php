<?php
class Job {
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

    public function addJob($data) {
        $sql = "INSERT INTO tbljobs (Company_ID, Title, pic, Salary, DateFrom, DateTo, Description, NumHours, Type, WorkPlace, VacantCount, EducationLevel, Course, WorkExperience, License)
                VALUES (:Company_ID, :Title, :pic, :Salary, :DateFrom, :DateTo, :Description, :NumHours, :Type, :WorkPlace, :VacantCount, :EducationLevel, :Course, :WorkExperience, :License)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':Company_ID' => $data['Company_ID'],
            ':Title' => $data['Title'],
            ':pic' => $data['pic'],
            ':Salary' => $data['Salary'],
            ':DateFrom' => $data['DateFrom'],
            ':DateTo' => $data['DateTo'],
            ':Description' => $data['Description'],
            ':NumHours' => $data['NumHours'],
            ':Type' => $data['Type'],
            ':WorkPlace' => $data['WorkPlace'],
            ':VacantCount' => $data['VacantCount'],
            ':EducationLevel' => $data['EducationLevel'],
            ':Course' => $data['Course'],
            ':WorkExperience' => $data['WorkExperience'],
            ':License' => $data['License'],
        ]);

        return $this->pdo->lastInsertId();
    }

    public function editJob($jobId, $data) {
        $sql = "UPDATE tbljobs SET Company_ID = :Company_ID, Title = :Title, Salary = :Salary, DateFrom = :DateFrom, DateTo = :DateTo, 
                Description = :Description, NumHours = :NumHours, Type = :Type, WorkPlace = :WorkPlace, VacantCount = :VacantCount, 
                EducationLevel = :EducationLevel, Course = :Course, WorkExperience = :WorkExperience, License = :License " ;

        if (!empty($data['pic'])) {
            $sql .= ", pic = :pic";
        }

        $sql .= " WHERE ID = :Job_ID";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':Company_ID' => $data['Company_ID'],
            ':Title' => $data['Title'],
            ':Salary' => $data['Salary'],
            ':DateFrom' => $data['DateFrom'],
            ':DateTo' => $data['DateTo'],
            ':Description' => $data['Description'],
            ':NumHours' => $data['NumHours'],
            ':Type' => $data['Type'],
            ':WorkPlace' => $data['WorkPlace'],
            ':VacantCount' => $data['VacantCount'],
            ':EducationLevel' => $data['EducationLevel'],
            ':Course' => $data['Course'],
            ':WorkExperience' => $data['WorkExperience'],
            ':License' => $data['License'],
            ':Job_ID' => $jobId,
        ];

        if (!empty($data['pic'])) {
            $params[':pic'] = $data['pic'];
        }

        $stmt->execute($params);
    }

    public function addTags($jobId, $tags) {
        // Delete existing tags for the given Job_ID
    $sqlDelete = "DELETE FROM tbltags WHERE Job_ID = :Job_ID";
    $stmtDelete = $this->pdo->prepare($sqlDelete);
    $stmtDelete->execute([':Job_ID' => $jobId]);

    // Insert new tags
    $sqlInsert = "INSERT INTO tbltags (Job_ID, Tags) VALUES (:Job_ID, :Tags)";
    $stmtInsert = $this->pdo->prepare($sqlInsert);

    foreach ($tags as $tag) {
        $filteredTag = $this->filterTag($tag);
        if ($filteredTag) {
            $stmtInsert->execute([
                ':Job_ID' => $jobId,
                ':Tags' => $filteredTag
            ]);
        }
    }
    }

    private function filterTag($tag) {
        $tag = trim($tag);
        $tag = filter_var($tag, FILTER_SANITIZE_STRING);

        if (!empty($tag)) {
            return $tag;
        }

        return null;
    }
}

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'PEESO'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Instantiate the Job class
$job = new Job($host, $dbname, $username, $password);

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'Company_ID' => filter_input(INPUT_POST, 'Company_ID', FILTER_VALIDATE_INT),
        'Title' => filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_STRING),
        'pic' => '', // Default empty string; will update if a file is uploaded
        'Salary' => filter_input(INPUT_POST, 'Salary', FILTER_VALIDATE_FLOAT),
        'DateFrom' => filter_input(INPUT_POST, 'DateFrom', FILTER_SANITIZE_STRING),
        'DateTo' => filter_input(INPUT_POST, 'DateTo', FILTER_SANITIZE_STRING),
        'Description' => filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_STRING),
        'NumHours' => filter_input(INPUT_POST, 'NumHours', FILTER_VALIDATE_INT),
        'Type' => filter_input(INPUT_POST, 'Type', FILTER_SANITIZE_STRING),
        'WorkPlace' => filter_input(INPUT_POST, 'WorkPlace', FILTER_SANITIZE_STRING),
        'VacantCount' => filter_input(INPUT_POST, 'VacantCount', FILTER_VALIDATE_INT),
        'EducationLevel' => filter_input(INPUT_POST, 'EducationLevel', FILTER_SANITIZE_STRING),
        'Course' => filter_input(INPUT_POST, 'Course', FILTER_SANITIZE_STRING),
        'WorkExperience' => filter_input(INPUT_POST, 'WorkExperience', FILTER_VALIDATE_INT),
        'License' => filter_input(INPUT_POST, 'License', FILTER_SANITIZE_STRING),
    ];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $companyname = filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING);
        $uploadDir = 'C:/xampp/htdocs/PEESOPORTAL/JOBS/ADMIN/JobPIC/' . $companyname . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $bytes = random_bytes(10);
        $randomString = bin2hex($bytes);
        $originalFileName = $_FILES['file']['name'];
        $originalExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = $randomString . '.' . $originalExtension;

        $uploadFile = $uploadDir . $newFileName;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

        $data['pic'] = $newFileName;
        $results['image'] = true;
    } else {
        $results['image'] = false;
    }

    // Assuming the job ID is passed via POST for editing an existing job
    $jobId = filter_input(INPUT_POST, 'Job_ID', FILTER_VALIDATE_INT);
    $tags = isset($_POST['tags']) ? json_decode($_POST['tags'], true) : [];
    if ($jobId) {
        $job->editJob($jobId, $data);
        $job->addTags($jobId, $tags);
        echo "Job record updated successfully";
    } else {
        $jobId = $job->addJob($data);
        if ($jobId) {
            
            $job->addTags($jobId, $tags);
            echo "New job record and tags created successfully";
        } else {
            echo "Error: Unable to add job";
        }
    }
}
?>
