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
        COUNT(tblappointment.job_ID) AS totalapplicant
            
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

    public function getCompaniesAppointment($CompanyID,$date)
    {
        // $query = "SELECT * FROM " . $this->U/serTable . " WHERE Company_ID = :CompanyID";
        $query = "SELECT 
        tbljobs.id as jobid,
        tblappointment.id as appointmentID,
        tbljobs.title,tbljobs.salary,
        concat('http://10.0.1.26:82/PEESOPORTAL/JOBS/ADMIN/JobPic/',tbljobs.pic) as pic,
        count(tblappointment.id) as totalAppointment,
        COALESCE(SUM(CASE WHEN tblappointment.status = 'CONFIRM' THEN 1 ELSE 0 END), 0) AS totalconfirm
            
        FROM 
            tblappointment
        left join
            tbljobs
        on
            tblappointment.job_ID=tbljobs.id
     
        
        
        WHERE 
            Company_ID = :CompanyID and tblappointment.appointment_date=:date 
        group by tblappointment.job_id
        
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':CompanyID', $CompanyID, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        // $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();

        $jobs= $stmt->fetchAll();
        foreach($jobs as &$job){
            
            $query="SELECT surname,firstname,middlename,Contactno,tblappointment.*,tblreschedule.appointment_date as RescheduleDate,tblreschedule.appointment_time as rescheduleTime from tblpersonal inner join tblappointment on tblpersonal.pmid=tblappointment.applicant_id left join tblreschedule on tblappointment.ID=tblreschedule.Appointment_ID  and tblreschedule.active=1 where tblappointment.job_id=:jobid and tblappointment.appointment_date=:date";
            
            $stmt=$this->pdo->prepare($query);
            $stmt->bindParam(':jobid', $job['jobid'], PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            $job['applicants']=$stmt->fetchAll(PDO::FETCH_OBJ);
        }
        return $jobs;
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
    $date=filter_input(INPUT_POST,'Date',FILTER_SANITIZE_STRING);
   
    if ($CompanyID === null || $CompanyID === false) {
        throw new InvalidArgumentException("CompanyID input is missing or invalid.");
    }

    
    $appointment=$companyRetriever->getCompaniesAppointment($CompanyID,$date);
    $results['success'] = true;
    $results['data'] = $appointment;
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