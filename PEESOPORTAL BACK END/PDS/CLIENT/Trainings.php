<?php

class TrainingManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xtrainings')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addTraining($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, Training, Dates, NumHours, Conductor, DateFrom, DateTo, type) 
                  VALUES 
                    (:ControlNo, :Training, :Dates, :NumHours, :Conductor, :DateFrom, :DateTo, :type)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editTraining($PMID, $data)
    {
        $data['PMID'] = $PMID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    Training = :Training,
                    Dates = :Dates,
                    NumHours = :NumHours,
                    Conductor = :Conductor,
                    DateFrom = :DateFrom,
                    DateTo = :DateTo,
                    type = :type
                  WHERE 
                    PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteTraining($PMID)
    {
        $query = "DELETE FROM {$this->table} WHERE PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getTrainingById($PMID)
    {
        $query = "SELECT * FROM {$this->table} WHERE controlno = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
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
    $trainingManager = new TrainingManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Training' => filter_input(INPUT_POST, 'Training', FILTER_SANITIZE_STRING),
                'Dates' => filter_input(INPUT_POST, 'Dates', FILTER_SANITIZE_STRING),
                'NumHours' => filter_input(INPUT_POST, 'NumHours', FILTER_VALIDATE_FLOAT),
                'Conductor' => filter_input(INPUT_POST, 'Conductor', FILTER_SANITIZE_STRING),
                'DateFrom' => filter_input(INPUT_POST, 'DateFrom', FILTER_SANITIZE_STRING),
                'DateTo' => filter_input(INPUT_POST, 'DateTo', FILTER_SANITIZE_STRING),
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
            ];
            $newId = $trainingManager->addTraining($data);
            $results['success'] = true;
            $results['message'] = 'Training added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Training' => filter_input(INPUT_POST, 'Training', FILTER_SANITIZE_STRING),
                'Dates' => filter_input(INPUT_POST, 'Dates', FILTER_SANITIZE_STRING),
                'NumHours' => filter_input(INPUT_POST, 'NumHours', FILTER_VALIDATE_FLOAT),
                'Conductor' => filter_input(INPUT_POST, 'Conductor', FILTER_SANITIZE_STRING),
                'DateFrom' => filter_input(INPUT_POST, 'DateFrom', FILTER_SANITIZE_STRING),
                'DateTo' => filter_input(INPUT_POST, 'DateTo', FILTER_SANITIZE_STRING),
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
            ];
            if ($trainingManager->editTraining($PMID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Training updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update training';
            }
            break;

        case 'delete':
            $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
            if ($trainingManager->deleteTraining($PMID)) {
                $results['success'] = true;
                $results['message'] = 'Training deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete training';
            }
            break;

        case 'view':
            $PMID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $training = $trainingManager->getTrainingById($PMID);
            $results['success'] = true;
            $results['data'] = $training;
            break;

        default:
            $results['success'] = false;
            $results['message'] = 'Invalid action';
            break;
    }
} catch (PDOException $e) {
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}

echo json_encode($results);
?>
