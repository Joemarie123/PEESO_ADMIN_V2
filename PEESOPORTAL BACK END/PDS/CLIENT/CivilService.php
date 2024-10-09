<?php

class CivilServiceManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xcivilservice')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addCivilService($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, Eligibility) 
                  VALUES 
                    (:ControlNo, :Eligibility)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editCivilService($ID, $data)
    {
        $data['ID'] = $ID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    Eligibility = :Eligibility
                  WHERE 
                    ID = :ID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteCivilService($ID)
    {
        $query = "DELETE FROM {$this->table} WHERE ID = :ID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCivilServiceById($ID)
    {
        $query = "SELECT * FROM {$this->table} WHERE Controlno = :ID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_STR);
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
    $civilServiceManager = new CivilServiceManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    
    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Eligibility' => filter_input(INPUT_POST, 'Eligibility', FILTER_SANITIZE_STRING),
            ];
            $newId = $civilServiceManager->addCivilService($data);
            $results['success'] = true;
            $results['message'] = 'Civil service eligibility added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Eligibility' => filter_input(INPUT_POST, 'Eligibility', FILTER_SANITIZE_STRING),
            ];
            if ($civilServiceManager->editCivilService($ID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Civil service eligibility updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update civil service eligibility';
            }
            break;

        case 'delete':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            if ($civilServiceManager->deleteCivilService($ID)) {
                $results['success'] = true;
                $results['message'] = 'Civil service eligibility deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete civil service eligibility';
            }
            break;

        case 'view':
            $ID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $civilService = $civilServiceManager->getCivilServiceById($ID);
            
            $results['success'] = true;
            $results['data'] = $civilService;
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
