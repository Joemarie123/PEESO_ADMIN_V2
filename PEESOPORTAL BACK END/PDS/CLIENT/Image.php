<?php
class UserInserter
{
    private $pdo;
    private $UserTable;
    private $loginTable;

    public function __construct($pdo, $UserTable = 'tblpersonal', $loginTable = 'tblLogin')
    {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
        $this->loginTable = $loginTable;
    }

    public function insertUserImage($Userpic,$userid)
    {
        $query = "UPDATE tblpersonal set pics=:pic where pmid=:id";
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(':pic', $Userpic, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userid, PDO::PARAM_INT);

        return $stmt->execute();
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
    $UserInserter = new UserInserter($pdo);

    //file uploading-encrypting the name then put to logos
    $userid=filter_input(INPUT_POST,'userid',FILTER_VALIDATE_INT);
    if (isset($_FILES['file'])) {
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $companyname=filter_input(INPUT_POST, 'Company_name', FILTER_SANITIZE_STRING);
            $uploadDir = 'C:/xampp/htdocs/PEESOPORTAL/PDS/Client/Image/' . $userid . '/';
            if(file_exists($uploadDir)){
                $bytes = random_bytes(10);
                $randomString = bin2hex($bytes);
                $originalFileName = $_FILES['file']['name'];
                $originalExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $newFileName = $randomString . '.' . $originalExtension;

                $uploadFile = $uploadDir . $newFileName;


                move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
            }else{
                mkdir($uploadDir);
                // $uploadDir = 'C:/xampp/htdocs/PEESOPORTAL/REGISTRATION/ADMIN/Logos/';
                $bytes = random_bytes(10);
                $randomString = bin2hex($bytes);
                $originalFileName = $_FILES['file']['name'];
                $originalExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $newFileName = $randomString . '.' . $originalExtension;

                $uploadFile = $uploadDir . $newFileName;


                move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
            }
            $results['image'] = true;
        }
    } else {
        $results['image'] = false;
        $newFileName = '';
    }
     $results['upload']=$UserInserter->insertUserImage($newFileName,$userid);
    
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}
echo json_encode($results);
?>