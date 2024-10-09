<?php

class SkillsManager
{
    private $pdo;
    private $table;

    public function __construct($pdo, $table = 'xskills')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function addSkill($data)
    {
        $query = "INSERT INTO {$this->table} 
                    (ControlNo, Skills) 
                  VALUES 
                    (:ControlNo, :Skills)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function editSkill($ID, $data)
    {
        $data['ID'] = $ID;
        $query = "UPDATE {$this->table} 
                  SET 
                    ControlNo = :ControlNo,
                    Skills = :Skills
                  WHERE 
                    ID = :ID";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteSkill($ID)
    {
        $query = "DELETE FROM {$this->table} WHERE ID = :ID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getSkillById($ID)
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
    $skillsManager = new SkillsManager($pdo);

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'add':
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Skills' => filter_input(INPUT_POST, 'Skills', FILTER_SANITIZE_STRING),
            ];
            $newId = $skillsManager->addSkill($data);
            $results['success'] = true;
            $results['message'] = 'Skill added successfully';
            $results['newId'] = $newId;
            break;

        case 'edit':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            $data = [
                'ControlNo' => filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING),
                'Skills' => filter_input(INPUT_POST, 'Skills', FILTER_SANITIZE_STRING),
            ];
            if ($skillsManager->editSkill($ID, $data)) {
                $results['success'] = true;
                $results['message'] = 'Skill updated successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to update skill';
            }
            break;

        case 'delete':
            $ID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
            if ($skillsManager->deleteSkill($ID)) {
                $results['success'] = true;
                $results['message'] = 'Skill deleted successfully';
            } else {
                $results['success'] = false;
                $results['message'] = 'Failed to delete skill';
            }
            break;

        case 'view':
            $ID = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
            $skill = $skillsManager->getSkillById($ID);
            $results['success'] = true;
            $results['data'] = $skill;
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
