<?php
class ChildrenManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addChild($ControlNo, $ChildName, $BirthDate)
    {
        $query = "INSERT INTO xchildren (ControlNo, ChildName, BirthDate) VALUES (:ControlNo, :ChildName, :BirthDate)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ControlNo', $ControlNo, PDO::PARAM_STR);
        $stmt->bindParam(':ChildName', $ChildName, PDO::PARAM_STR);
        $stmt->bindParam(':BirthDate', $BirthDate, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateChild($PMID, $ControlNo, $ChildName, $BirthDate)
    {
        $query = "UPDATE xchildren SET
            ControlNo = :ControlNo,
            ChildName = :ChildName,
            BirthDate = :BirthDate
        WHERE PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_INT);
        $stmt->bindParam(':ControlNo', $ControlNo, PDO::PARAM_STR);
        $stmt->bindParam(':ChildName', $ChildName, PDO::PARAM_STR);
        $stmt->bindParam(':BirthDate', $BirthDate, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteChild($PMID)
    {
        $query = "DELETE FROM xchildren WHERE PMID = :PMID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':PMID', $PMID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getChildren($ControlNo)
    {
        $query = "SELECT * FROM xchildren WHERE ControlNo = :ControlNo";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ControlNo', $ControlNo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dsn = 'mysql:host=localhost;dbname=PEESO';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $pdo = new PDO($dsn, $username, $password, $options);
        $childrenManager = new ChildrenManager($pdo);

        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

        $results = [];
        switch ($action) {
            case 'add':
                $ControlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
                $ChildName = filter_input(INPUT_POST, 'ChildName', FILTER_SANITIZE_STRING);
                $BirthDate = filter_input(INPUT_POST, 'BirthDate', FILTER_SANITIZE_STRING);

                $success = $childrenManager->addChild($ControlNo, $ChildName, $BirthDate);
                if ($success) {
                    $results['success'] = true;
                    $results['message'] = 'Child record added successfully';
                } else {
                    $results['success'] = false;
                    $results['message'] = 'Failed to add child record';
                }
                break;

            case 'edit':
                $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);
                $ControlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
                $ChildName = filter_input(INPUT_POST, 'ChildName', FILTER_SANITIZE_STRING);
                $BirthDate = filter_input(INPUT_POST, 'BirthDate', FILTER_SANITIZE_STRING);

                $success = $childrenManager->updateChild($PMID, $ControlNo, $ChildName, $BirthDate);
                if ($success) {
                    $results['success'] = true;
                    $results['message'] = 'Child record updated successfully';
                } else {
                    $results['success'] = false;
                    $results['message'] = 'Failed to update child record';
                }
                break;

            case 'delete':
                $PMID = filter_input(INPUT_POST, 'PMID', FILTER_VALIDATE_INT);

                $success = $childrenManager->deleteChild($PMID);
                if ($success) {
                    $results['success'] = true;
                    $results['message'] = 'Child record deleted successfully';
                } else {
                    $results['success'] = false;
                    $results['message'] = 'Failed to delete child record';
                }
                break;

            case 'view':
                $ControlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);

                $children = $childrenManager->getChildren($ControlNo);
                if ($children) {
                    $results['success'] = true;
                    $results['children'] = $children;
                } else {
                    $results['success'] = false;
                    $results['message'] = 'No children records found';
                }
                break;

            default:
                $results['success'] = false;
                $results['message'] = 'Invalid action';
                break;
        }

        echo json_encode($results);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database connection failed: ' . $e->getMessage(),
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method',
    ]);
}
