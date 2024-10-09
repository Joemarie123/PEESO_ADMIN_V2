<?php
class PersonalManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function updatePersonal($ControlNo, $data)
    {
        $query = "UPDATE tblpersonal SET
            Surname = :Surname,
            Firstname = :Firstname,
            Middlename = :Middlename,
            Suffix = :Suffix,
            Sex = :Sex, 
            CivilStatus = :CivilStatus,
            MaidenName = :MaidenName,
            SpouseName = :SpouseName,
            Occupation = :Occupation,
            TINNo = :TINNo,
            GSISNo = :GSISNo,
            PAGIBIGNo = :PAGIBIGNo,
            SSSNo = :SSSNo,
            PHEALTHNo = :PHEALTHNo,
            Citizenship = :Citizenship,
            Religion = :Religion,
            BirthDate = :BirthDate,
            BirthPlace = :BirthPlace,
            Heights = :Heights,
            Weights = :Weights,
            BloodType = :BloodType,
            Address = :Address,
            TelNo = :TelNo,
            FatherName = :FatherName,
            FatherBirth = :FatherBirth,
            MotherName = :MotherName,
            MotherBirth = :MotherBirth,
            Skills = :Skills,
            Qualifications = :Qualifications,
            Q1 = :Q1,
            R11 = :R11,
            Q11 = :Q11,
            R1 = :R1,
            Q2 = :Q2,
            Q22 = :Q22,
            R2 = :R2,
            Q3 = :Q3,
            R3 = :R3,
            Q4 = :Q4,
            R4 = :R4,
            Q5 = :Q5,
            R5 = :R5,
            Q6 = :Q6,
            R6 = :R6,
            Q7 = :Q7,
            R7 = :R7,
            Tax = :Tax,
            DateRegistered = :DateRegistered,
            Pics = :Pics,
            
            Email = :Email,
            ContactNo = :ContactNo,
            EmailAdd = :EmailAdd,
            CellphoneNo = :CellphoneNo,
            SpouseFirstname = :SpouseFirstname,
            SpouseMiddlename = :SpouseMiddlename,
            SpouseEmployer = :SpouseEmployer,
            SpouseEmpAddress = :SpouseEmpAddress,
            SpouseEmpTel = :SpouseEmpTel,
            FatherFirstname = :FatherFirstname,
            FatherMiddlename = :FatherMiddlename,
            MotherFirstname = :MotherFirstname,
            MotherMiddlename = :MotherMiddlename,
            IP = :IP,
            IPR = :IPR,
            PWD = :PWD,
            PWDR = :PWDR,
            SoloP = :SoloP,
            SoloPR = :SoloPR,
            Rhouse = :Rhouse,
            Rstreet = :Rstreet,
            Rsubdivision = :Rsubdivision,
            Rbarangay = :Rbarangay,
            Rcity = :Rcity,
            Rprovince = :Rprovince,
            Rregion = :Rregion,
            Rzip = :Rzip,
            Pregion = :Pregion,
            Phouse = :Phouse,
            Pstreet = :Pstreet,
            Psubdivision = :Psubdivision,
            Pbarangay = :Pbarangay,
            Pcity = :Pcity,
            Pprovince = :Pprovince,
            Pzip = :Pzip,
            local = :local,
            localdetails = :localdetails,
            country = :country,
            countrydetails = :countrydetails,
            datefiled = :datefiled,
            gender = :gender,
            citizenshipStatus = :citizenshipStatus,
            birthcountry = :birthcountry
        WHERE ControlNo = :ControlNo";

        $stmt = $this->pdo->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':ControlNo', $ControlNo);

        return $stmt->execute();
    }

    public function getPersonal($ControlNo)
    {
        $query = "SELECT *,concat('http://10.0.1.26:82/PEESOPORTAL/PDS/CLIENT/Image/',tblpersonal.pmid,'/',tblpersonal.pics) as pic FROM tblpersonal WHERE ControlNo = :ControlNo";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':ControlNo', $ControlNo);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dsn = 'mysql:host=localhost;dbname=peeso';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $pdo = new PDO($dsn, $username, $password, $options);
        $personalManager = new PersonalManager($pdo);

        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

        $results = [];
        switch ($action) {
            case 'edit':
                $ControlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
                $data = [
                    'Surname' => filter_input(INPUT_POST, 'Surname', FILTER_SANITIZE_STRING),
                    'Firstname' => filter_input(INPUT_POST, 'Firstname', FILTER_SANITIZE_STRING),
                    'Middlename' => filter_input(INPUT_POST, 'Middlename', FILTER_SANITIZE_STRING),
                    'Suffix' => filter_input(INPUT_POST, 'Suffix', FILTER_SANITIZE_STRING),
                    'Sex' => filter_input(INPUT_POST, 'Sex', FILTER_SANITIZE_STRING),
                    'CivilStatus' => filter_input(INPUT_POST, 'CivilStatus', FILTER_SANITIZE_STRING),
                    'MaidenName' => filter_input(INPUT_POST, 'MaidenName', FILTER_SANITIZE_STRING),
                    'SpouseName' => filter_input(INPUT_POST, 'SpouseName', FILTER_SANITIZE_STRING),
                    'Occupation' => filter_input(INPUT_POST, 'Occupation', FILTER_SANITIZE_STRING),
                    'TINNo' => filter_input(INPUT_POST, 'TINNo', FILTER_SANITIZE_STRING),
                    'GSISNo' => filter_input(INPUT_POST, 'GSISNo', FILTER_SANITIZE_STRING),
                    'PAGIBIGNo' => filter_input(INPUT_POST, 'PAGIBIGNo', FILTER_SANITIZE_STRING),
                    'SSSNo' => filter_input(INPUT_POST, 'SSSNo', FILTER_SANITIZE_STRING),
                    'PHEALTHNo' => filter_input(INPUT_POST, 'PHEALTHNo', FILTER_SANITIZE_STRING),
                    'Citizenship' => filter_input(INPUT_POST, 'Citizenship', FILTER_SANITIZE_STRING),
                    'Religion' => filter_input(INPUT_POST, 'Religion', FILTER_SANITIZE_STRING),
                    'BirthDate' => filter_input(INPUT_POST, 'BirthDate', FILTER_SANITIZE_STRING),
                    'BirthPlace' => filter_input(INPUT_POST, 'BirthPlace', FILTER_SANITIZE_STRING),
                    'Heights' => filter_input(INPUT_POST, 'Heights', FILTER_SANITIZE_STRING),
                    'Weights' => filter_input(INPUT_POST, 'Weights', FILTER_SANITIZE_STRING),
                    'BloodType' => filter_input(INPUT_POST, 'BloodType', FILTER_SANITIZE_STRING),
                    'Address' => filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_STRING),
                    'TelNo' => filter_input(INPUT_POST, 'TelNo', FILTER_SANITIZE_STRING),
                    'FatherName' => filter_input(INPUT_POST, 'FatherName', FILTER_SANITIZE_STRING),
                    'FatherBirth' => filter_input(INPUT_POST, 'FatherBirth', FILTER_SANITIZE_STRING),
                    'MotherName' => filter_input(INPUT_POST, 'MotherName', FILTER_SANITIZE_STRING),
                    'MotherBirth' => filter_input(INPUT_POST, 'MotherBirth', FILTER_SANITIZE_STRING),
                    'Skills' => filter_input(INPUT_POST, 'Skills', FILTER_SANITIZE_STRING),
                    'Qualifications' => filter_input(INPUT_POST, 'Qualifications', FILTER_SANITIZE_STRING),
                    'Q1' => filter_input(INPUT_POST, 'Q1', FILTER_SANITIZE_STRING),
                    'R11' => filter_input(INPUT_POST, 'R11', FILTER_SANITIZE_STRING),
                    'Q11' => filter_input(INPUT_POST, 'Q11', FILTER_SANITIZE_STRING),
                    'R1' => filter_input(INPUT_POST, 'R1', FILTER_SANITIZE_STRING),
                    'Q2' => filter_input(INPUT_POST, 'Q2', FILTER_SANITIZE_STRING),
                    'Q22' => filter_input(INPUT_POST, 'Q22', FILTER_SANITIZE_STRING),
                    'R2' => filter_input(INPUT_POST, 'R2', FILTER_SANITIZE_STRING),
                    'Q3' => filter_input(INPUT_POST, 'Q3', FILTER_SANITIZE_STRING),
                    'R3' => filter_input(INPUT_POST, 'R3', FILTER_SANITIZE_STRING),
                    'Q4' => filter_input(INPUT_POST, 'Q4', FILTER_SANITIZE_STRING),
                    'R4' => filter_input(INPUT_POST, 'R4', FILTER_SANITIZE_STRING),
                    'Q5' => filter_input(INPUT_POST, 'Q5', FILTER_SANITIZE_STRING),
                    'R5' => filter_input(INPUT_POST, 'R5', FILTER_SANITIZE_STRING),
                    'Q6' => filter_input(INPUT_POST, 'Q6', FILTER_SANITIZE_STRING),
                    'R6' => filter_input(INPUT_POST, 'R6', FILTER_SANITIZE_STRING),
                    'Q7' => filter_input(INPUT_POST, 'Q7', FILTER_SANITIZE_STRING),
                    'R7' => filter_input(INPUT_POST, 'R7', FILTER_SANITIZE_STRING),
                    'Tax' => filter_input(INPUT_POST, 'Tax', FILTER_SANITIZE_STRING),
                    'DateRegistered' => filter_input(INPUT_POST, 'DateRegistered', FILTER_SANITIZE_STRING),
                    'Pics' => filter_input(INPUT_POST, 'Pics', FILTER_SANITIZE_STRING),
                    
                    'Email' => filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_STRING),
                    'ContactNo' => filter_input(INPUT_POST, 'ContactNo', FILTER_SANITIZE_STRING),
                    'EmailAdd' => filter_input(INPUT_POST, 'EmailAdd', FILTER_SANITIZE_STRING),
                    'CellphoneNo' => filter_input(INPUT_POST, 'CellphoneNo', FILTER_SANITIZE_STRING),
                    'SpouseFirstname' => filter_input(INPUT_POST, 'SpouseFirstname', FILTER_SANITIZE_STRING),
                    'SpouseMiddlename' => filter_input(INPUT_POST, 'SpouseMiddlename', FILTER_SANITIZE_STRING),
                    'SpouseEmployer' => filter_input(INPUT_POST, 'SpouseEmployer', FILTER_SANITIZE_STRING),
                    'SpouseEmpAddress' => filter_input(INPUT_POST, 'SpouseEmpAddress', FILTER_SANITIZE_STRING),
                    'SpouseEmpTel' => filter_input(INPUT_POST, 'SpouseEmpTel', FILTER_SANITIZE_STRING),
                    'FatherFirstname' => filter_input(INPUT_POST, 'FatherFirstname', FILTER_SANITIZE_STRING),
                    'FatherMiddlename' => filter_input(INPUT_POST, 'FatherMiddlename', FILTER_SANITIZE_STRING),
                    'MotherFirstname' => filter_input(INPUT_POST, 'MotherFirstname', FILTER_SANITIZE_STRING),
                    'MotherMiddlename' => filter_input(INPUT_POST, 'MotherMiddlename', FILTER_SANITIZE_STRING),
                    'IP' => filter_input(INPUT_POST, 'IP', FILTER_SANITIZE_STRING),
                    'IPR' => filter_input(INPUT_POST, 'IPR', FILTER_SANITIZE_STRING),
                    'PWD' => filter_input(INPUT_POST, 'PWD', FILTER_SANITIZE_STRING),
                    'PWDR' => filter_input(INPUT_POST, 'PWDR', FILTER_SANITIZE_STRING),
                    'SoloP' => filter_input(INPUT_POST, 'SoloP', FILTER_SANITIZE_STRING),
                    'SoloPR' => filter_input(INPUT_POST, 'SoloPR', FILTER_SANITIZE_STRING),
                    'Rhouse' => filter_input(INPUT_POST, 'Rhouse', FILTER_SANITIZE_STRING),
                    'Rstreet' => filter_input(INPUT_POST, 'Rstreet', FILTER_SANITIZE_STRING),
                    'Rsubdivision' => filter_input(INPUT_POST, 'Rsubdivision', FILTER_SANITIZE_STRING),
                    'Rbarangay' => filter_input(INPUT_POST, 'Rbarangay', FILTER_SANITIZE_STRING),
                    'Rcity' => filter_input(INPUT_POST, 'Rcity', FILTER_SANITIZE_STRING),
                    'Rprovince' => filter_input(INPUT_POST, 'Rprovince', FILTER_SANITIZE_STRING),
                    'Rregion' => filter_input(INPUT_POST, 'Rregion', FILTER_SANITIZE_STRING),
                    'Rzip' => filter_input(INPUT_POST, 'Rzip', FILTER_SANITIZE_STRING),
                    'Pregion' => filter_input(INPUT_POST, 'Pregion', FILTER_SANITIZE_STRING),
                    'Phouse' => filter_input(INPUT_POST, 'Phouse', FILTER_SANITIZE_STRING),
                    'Pstreet' => filter_input(INPUT_POST, 'Pstreet', FILTER_SANITIZE_STRING),
                    'Psubdivision' => filter_input(INPUT_POST, 'Psubdivision', FILTER_SANITIZE_STRING),
                    'Pbarangay' => filter_input(INPUT_POST, 'Pbarangay', FILTER_SANITIZE_STRING),
                    'Pcity' => filter_input(INPUT_POST, 'Pcity', FILTER_SANITIZE_STRING),
                    'Pprovince' => filter_input(INPUT_POST, 'Pprovince', FILTER_SANITIZE_STRING),
                    'Pzip' => filter_input(INPUT_POST, 'Pzip', FILTER_SANITIZE_STRING),
                    'local' => filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING),
                    'localdetails' => filter_input(INPUT_POST, 'localdetails', FILTER_SANITIZE_STRING),
                    'country' => filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING),
                    'countrydetails' => filter_input(INPUT_POST, 'countrydetails', FILTER_SANITIZE_STRING),
                    'datefiled' => filter_input(INPUT_POST, 'datefiled', FILTER_SANITIZE_STRING),
                    'gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING),
                    'citizenshipStatus' => filter_input(INPUT_POST, 'citizenshipStatus', FILTER_SANITIZE_STRING),
                    'birthcountry' => filter_input(INPUT_POST, 'birthcountry', FILTER_SANITIZE_STRING),
                ];

                $success = $personalManager->updatePersonal($ControlNo, $data);
                if ($success) {
                    $results['success'] = true;
                    $results['message'] = 'Personal record updated successfully';
                } else {
                    $results['success'] = false;
                    $results['message'] = 'Failed to update personal record';
                }
                break;

            case 'view':
                $ControlNo = filter_input(INPUT_POST, 'ControlNo', FILTER_SANITIZE_STRING);
                $personalRecord = $personalManager->getPersonal($ControlNo);
                if ($personalRecord) {
                    $results['success'] = true;
                    $results['personalRecord'] = $personalRecord;
                } else {
                    $results['success'] = false;
                    $results['message'] = 'No personal record found';
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
