<?php

class ReferenceManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xreference')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addReference($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, Names, Address, TelNo) 
                  VALUES 
                    (:ControlNo, :Names, :Address, :TelNo)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editReference($PMID, $data)
    {
        $data['PMID'] = $PMID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    Names = :Names,
                    Address = :Address,
                    TelNo = :TelNo
                  WHERE 
                    PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteReference($PMID)
    {
        $query = "DELETE FROM {$this->table} WHERE PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReferenceById($PMID)
    {
        $query = "SELECT * FROM {$this->table} WHERE COntrolNo = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchall();
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
    $referenceManager = new ReferenceManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Names' => filter_input(INPUT_POST, 'Names', FILTER_SANITIZE_STRING),
                'Address' => filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_STRING),
                'TelNo' => filter_input(INPUT_POST, 'TelNo', FILTER_SANITIZE_STRING),
            ];
            $newId = $referenceManager->addReference($data);
            $results['success'] = true;
            $results['message'] = 'Reference added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Names' => filter_input(INPUT_POST, 'Names', FILTER_SANITIZE_STRING),
                'Address' => filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_STRING),
                'TelNo' => filter_input(INPUT_POST, 'TelNo', FILTER_SANITIZE_STRING),
            ];
            if ($referenceManager->editReference($PMID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Reference updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update reference';
            }
            break;

        case 'delete':
            $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
            if ($referenceManager->deleteReference($PMID)) {
                $results['success'] = true;
                $results['message'] = 'Reference deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete reference';
            }
            break;

        case 'view':
            $PMID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $reference = $referenceManager->getReferenceById($PMID);
            $results['success'] = true;
            $results['data'] = $reference;
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
