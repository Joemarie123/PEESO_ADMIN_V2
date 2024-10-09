<?php

class NonAcademicManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xnonacademic')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addNonAcademic($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, NonAcademic) 
                  VALUES 
                    (:ControlNo, :NonAcademic)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editNonAcademic($ID, $data)
    {
        $data['ID'] = $ID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    NonAcademic = :NonAcademic
                  WHERE 
                    ID = :ID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteNonAcademic($ID)
    {
        $query = "DELETE FROM {$this->table} WHERE ID = :ID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getNonAcademicById($ID)
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
    $nonAcademicManager = new NonAcademicManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'NonAcademic' => filter_input(INPUT_POST, 'NonAcademic', FILTER_SANITIZE_STRING),
            ];
            $newId = $nonAcademicManager->addNonAcademic($data);
            $results['success'] = true;
            $results['message'] = 'Non-academic achievement added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'NonAcademic' => filter_input(INPUT_POST, 'NonAcademic', FILTER_SANITIZE_STRING),
            ];
            if ($nonAcademicManager->editNonAcademic($ID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Non-academic achievement updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update non-academic achievement';
            }
            break;

        case 'delete':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            if ($nonAcademicManager->deleteNonAcademic($ID)) {
                $results['success'] = true;
                $results['message'] = 'Non-academic achievement deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete non-academic achievement';
            }
            break;

        case 'view':
            $ID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $nonAcademic = $nonAcademicManager->getNonAcademicById($ID);
            $results['success'] = true;
            $results['data'] = $nonAcademic;
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
