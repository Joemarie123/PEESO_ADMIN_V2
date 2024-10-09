<?php
class CompanyAppointmentRetriever
{
    private $pdo;
    private $UserTable;

    public function __construct($pdo, $UserTable = 'tbljobs')
    {
        $this->pdo = $pdo;
        $this->UserTable = $UserTable;
    }

    public function getCompaniesByLoginID($CompanyID)
    {

        $query="UPDATE tbljobs set status='OVERDUE' where datefrom < curdate() and company_ID=:CompanyID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->execute();
        
        $query = "SELECT 
        count(tbljobs.id) as totaljobs,
        COALESCE(SUM(CASE WHEN tbljobs.status<>'CLOSED' THEN 1 ELSE 0 END), 0) AS ActiveJobs,
        COALESCE(SUM(CASE WHEN tbljobs.status='OVERDUE' THEN 1 ELSE 0 END), 0) AS OverdueJobs,
        COALESCE(SUM(CASE WHEN tbljobs.status='CLOSED' THEN 1 ELSE 0 END), 0) AS ClosedJobs
            
        FROM 
            tbljobs 
        
        WHERE 
            tbljobs.Company_ID = :CompanyID 
        GROUP BY 
            tbljobs.company_ID
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
      
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // public function getCompaniesAppointment($CompanyID,$month,$year)
    // {
    //     // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
    //     $query = "SELECT 
    //     tblappointment.*,tbljobs.title,tbljobs.salary,
    //     concat('http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/',tbljobs.pic) as pic,
    //     surname,firstname, contactno
            
    //     FROM 
    //         tblappointment
    //     inner join
    //         tbljobs
    //     on
    //         tblappointment.job_ID=tbljobs.id
    //     inner join
    //         tblpersonal
    //     on
    //         tblappointment.applicant_id=tblpersonal.pmid

        
        
    //     WHERE 
    //         Company_ID = :CompanyID and month(tblappointment.appointment_date)=:month and year(tblappointment.appointment_date)=:year
        
    //     ";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
    //     $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    //     $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    //     $stmt->execute();

    //     return $stmt->fetchAll();
    // }
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
    $companyRetriever = new CompanyAppointmentRetriever($pdo);

    // Retrieve the LoginID from the form data
    $CompanyID = filter_input(INPUT_POST, 'CompanyID', FILTER_VALIDATE_INT);
   
    if ($CompanyID === null || $CompanyID === false) {
        throw new InvalidArgumentException("CompanyID input is missing or invalid.");
    }

    $companies = $companyRetriever->getCompaniesByLoginID($CompanyID);
    // $appointment=$companyRetriever->getCompaniesAppointment($CompanyID,$month,$year);
    $results['success'] = true;
    $results['data'] = $companies;
    // $results['appointment']=$appointment;
} catch (PDOException $e) {
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}

echo json_encode($results);
?>