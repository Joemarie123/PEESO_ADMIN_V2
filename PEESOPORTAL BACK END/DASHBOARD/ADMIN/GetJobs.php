<?php
class CompanyJobsRetriever {
    private $pdo;
    private $UserTable;

    public function __construct($pdo, $UserTable = 'tbljobs') {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
    }

    public function getCompaniesByLoginID($CompanyID) {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";

       

        $query="SELECT 
        tbljobs.*,
        concat('http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/',pic) as jobpic,
        
        COUNT(tblapplication.ID) AS totalapplicant,
        COALESCE(SUM(CASE WHEN tblapplication.status = 'HIRED' THEN 1 ELSE 0 END), 0) AS totalhired,
        COALESCE(SUM(CASE WHEN tblapplication.status = 'ACCEPTED' THEN 1 ELSE 0 END), 0) AS totalaccepted,
        COALESCE(SUM(CASE WHEN tblapplication.status = 'DECLINED' THEN 1 ELSE 0 END), 0) AS totalrejected
    FROM 
        tbljobs 
    LEFT JOIN 
        tblapplication 
    ON 
        tbljobs.ID = tblapplication.Job_ID 
    WHERE 
        tbljobs.Company_ID = :CompanyID
    GROUP BY 
        tbljobs.ID desc;
   
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->execute();
        
        $jobs= $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($jobs as &$job){
            
            $query="SELECT tags from tbltags where job_id=:jobid";
            $stmt=$this->pdo->prepare($query);
            $stmt->bindParam(':jobid', $job['ID'], PDO::PARAM_INT);
            $stmt->execute();
            $job['tags']=$stmt->fetchAll(PDO::FETCH_ASSOC);
            // echo json_encode($job);
        }
        return $jobs;
    }

    public function getTotalACtiveJobs($CompanyID) {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
        $query="SELECT 
        COUNT(tbljobs.ID) as totaljobs
    FROM 
        tbljobs 
    
    WHERE 
        tbljobs.Company_ID = :CompanyID and currentdate between datefrom and dateto
    GROUP BY 
        tbljobs.ID;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    public function getVacantPosition($CompanyID) {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
        $query="SELECT 
        SUM(tbljobs.vacancount)-count(tblapplication.id) as totalVacantPosition
    FROM 
        tbljobs 
        LEFT JOIN 
        tblapplication 
    ON 
        tbljobs.ID = tblapplication.Job_ID 
    WHERE 
        tbljobs.Company_ID = :CompanyID and currentdate between datefrom and dateto and tblapplication.status='HIRED'
    GROUP BY 
        tbljobs.ID;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
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
    $companyRetriever = new CompanyJobsRetriever($pdo);

    // Retrieve the LoginID from the form data
    $CompanyID = filter_input(INPUT_POST, 'CompanyID', FILTER_VALIDATE_INT);
    if ($CompanyID === null || $CompanyID === false) {
        throw new InvalidArgumentException("CompanyID input is missing or invalid.");
    }

    $companies = $companyRetriever->getCompaniesByLoginID($CompanyID);
    $results['success'] = true;
    $results['data'] = $companies;
} catch (PDOException $e) {
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}

echo json_encode($results);
?>
