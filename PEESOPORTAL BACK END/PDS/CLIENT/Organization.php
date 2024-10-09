<?php

class OrganizationManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xorganization')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addOrganization($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, Organization) 
                  VALUES 
                    (:ControlNo, :Organization)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editOrganization($ID, $data)
    {
        $data['ID'] = $ID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    Organization = :Organization
                  WHERE 
                    ID = :ID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteOrganization($ID)
    {
        $query = "DELETE FROM {$this->table} WHERE ID = :ID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getOrganizationById($ID)
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
    $organizationManager = new OrganizationManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Organization' => filter_input(INPUT_POST, 'Organization', FILTER_SANITIZE_STRING),
            ];
            $newId = $organizationManager->addOrganization($data);
            $results['success'] = true;
            $results['message'] = 'Organization added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Organization' => filter_input(INPUT_POST, 'Organization', FILTER_SANITIZE_STRING),
            ];
            if ($organizationManager->editOrganization($ID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Organization updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update organization';
            }
            break;

        case 'delete':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            if ($organizationManager->deleteOrganization($ID)) {
                $results['success'] = true;
                $results['message'] = 'Organization deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete organization';
            }
            break;

        case 'view':
            $ID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $organization = $organizationManager->getOrganizationById($ID);
            $results['success'] = true;
            $results['data'] = $organization;
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
