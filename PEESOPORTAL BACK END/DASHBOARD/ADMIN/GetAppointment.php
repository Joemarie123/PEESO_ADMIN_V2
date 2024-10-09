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

    public function getCompaniesByLoginID($CompanyID,$month,$year)
    {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
        $query = "SELECT 
        tbljobs.title,
        tbljobs.salary,
          
        tblappointment.appointment_date,
        COUNT(tblappointment.job_ID) AS totalapplicant,
        count(CASE WHEN tblappointment.status='CONFIRM' then 1 else 0 END) as totalconfirm
            
        FROM 
            tbljobs 
        inner JOIN 
            tblappointment 
        ON 
            tbljobs.ID = tblappointment.Job_ID 
        WHERE 
            tbljobs.Company_ID = :CompanyID and month(tblappointment.appointment_date)=:month and year(tblappointment.appointment_date)=:year
        GROUP BY 
            tblappointment.appointment_date,tbljobs.title;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getCompaniesAppointment($CompanyID,$month,$year)
    {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
        $query = "SELECT 
        tblappointment.*,tbljobs.title,tbljobs.salary,
        concat('http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/',tbljobs.pic) as pic,
        surname,firstname, contactno
            
        FROM 
            tblappointment
        inner join
            tbljobs
        on
            tblappointment.job_ID=tbljobs.id
        inner join
            tblpersonal
        on
            tblappointment.applicant_id=tblpersonal.pmid
        
        
        WHERE 
            Company_ID = :CompanyID and month(tblappointment.appointment_date)=:month and year(tblappointment.appointment_date)=:year
        
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
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
    $companyRetriever = new CompanyAppointmentRetriever($pdo);

    // Retrieve the LoginID from the form data
    $CompanyID = filter_input(INPUT_POST, 'CompanyID', FILTER_VALIDATE_INT);
    $month=filter_input(INPUT_POST,'month',FILTER_VALIDATE_INT);
    $year=filter_input(INPUT_POST,'year',FILTER_VALIDATE_INT);
    if ($CompanyID === null || $CompanyID === false) {
        throw new InvalidArgumentException("CompanyID input is missing or invalid.");
    }

    $companies = $companyRetriever->getCompaniesByLoginID($CompanyID,$month,$year);
    $appointment=$companyRetriever->getCompaniesAppointment($CompanyID,$month,$year);
    $results['success'] = true;
    $results['data'] = $companies;
    $results['appointment']=$appointment;
} catch (PDOException $e) {
    $results['success'] = false;
    $results['message'] = "Database connection failed: " . $e->getMessage();
} catch (InvalidArgumentException $e) {
    $results['success'] = false;
    $results['message'] = $e->getMessage();
}

echo json_encode($results);
?>