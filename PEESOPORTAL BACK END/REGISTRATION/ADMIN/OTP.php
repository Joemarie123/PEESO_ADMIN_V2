<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';
class OTP {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = "";

  public $otpPass="";
  function __construct() {
    $this->pdo = new PDO(
      "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
      DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  // (B) DESTRUCTOR - CLOSE CONNECTION
  function __destruct() {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  // (C) HELPER - RUN SQL QUERY
  function query ($sql, $data=null) : void {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) GENERATE OTP
  function generate ($email) {
    // (D1) CHECK EXISTING OTP REQUEST
    // $this->query("SELECT * FROM `tblotp` WHERE `email`=?", [$email]);
    // $otp = $this->stmt->fetch();
    // if (is_array($otp) && (strtotime("now") < strtotime($otp["timestamp"]) + (OTP_VALID * 60))) {
    //   $this->error = "You already have a pending OTP.";
    //   return false;
    // }

    // (D2) CREATE RANDOM OTP
    $alphabets = "0123456789";
    $count = strlen($alphabets) - 1;
    $pass = "";
    for ($i=0; $i<OTP_LEN; $i++) { $pass .= $alphabets[rand(0, $count)]; }
    // $this->query(
    //   "REPLACE INTO `tblotp` (`email`, `pass`) VALUES (?,?)",
    //   [$email, password_hash($pass, PASSWORD_DEFAULT)]
    // );

     // (D3) SEND VIA EMAIL USING PHPMailer
     $mail = new PHPMailer(true);
     try {
       //Server settings
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
       $mail->SMTPAuth = true;
       $mail->Username = 'mahusayjograd@gmail.com'; // SMTP username
       $mail->Password = 'mfdp feje aill bgcy'; // SMTP password
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
       $mail->Port = 587;
 
       //Recipients
       $mail->setFrom('mahusayjograd@gmail.com', 'CPESCDO WEB APP');
       $mail->addAddress($email);
 
       // Content
       $mail->isHTML(true);
       $mail->Subject = 'CPESCDO WEB APP REGISTRATION';
       $mail->Body    = "Your Authorization Code is $pass. ";
       $mail->AltBody = "Your Authorization Code is $pass. ";
 
       $mail->send();

      $this->otpPass=$pass;
      //  $response['otp']=$pass;
       return true;
     } catch (Exception $e) {
        // $this->query("DELETE from `tblotp` where `email`=?",[$email]);

       $this->error = "Failed to send OTP email. Mailer Error: {$mail->ErrorInfo}";
       return false;
     }
   }

  // (E) CHALLENGE OTP
  function challenge ($email, $pass) {
    // (E1) GET THE OTP ENTRY
    $this->query("SELECT * FROM `tblotp` WHERE `email`=?", [$email]);
    $otp = $this->stmt->fetch();

    // (E2) CHECK - NOT FOUND
    if (!is_array($otp)) {
      $this->error = "The specified OTP request is not found.";
      return false;
    }

    // (E3) CHECK - EXPIRED
    if (strtotime("now") > strtotime($otp["timestamp"]) + (OTP_VALID * 60)) {
      $this->error = "OTP has expired.";
      return false;
    }

    // (E4) CHECK - INCORRECT PASSWORD
    if (!password_verify($pass, $otp["pass"])) {
      $this->error = "Incorrect OTP.";
      return false;
    }

    // (E5) OK - DELETE OTP REQUEST
    $this->query("DELETE FROM `tblotp` WHERE `email`=?", [$email]);
    return true;
  }
}

// (F) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "PEESO");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// (G) OTP SETTINGS
define("OTP_VALID", "15"); // otp valid for n minutes
define("OTP_LEN", "6");    // otp length

// (H) NEW OTP OBJECT
$_OTP = new OTP();

// Handle the request
// $action = isset($_POST['action']) ? $_POST['action'] : null;
$email = isset($_POST['Email']) ? $_POST['Email'] : null;
// $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

$response = [];
if ($email!=null){
  if($_OTP->generate($email)){
    $response['otp']=$_OTP->otpPass;
    $response['sent']=true;
  }else{
    $response['otp']=$_OTP->error;
    $response['sent']=false;
  }
}else{
  $response['otp']="INVALID";
}
// switch ($action) {
//   case 'generate':
//     if ($email && $_OTP->generate($email)) {
//       $response = ['status' => 'success', 'message' => 'OTP sent successfully.'];
//     } else {
//       $response = ['status' => 'error', 'message' => $_OTP->error];
//     }
//     break;

//   case 'challenge':
//     if ($email && $pass && $_OTP->challenge($email, $pass)) {
//       $response = ['status' => 'success', 'message' => 'OTP verified successfully.'];
//     } else {
//       $response = ['status' => 'error', 'message' => $_OTP->error];
//     }
//     break;

//   default:
//     $response = ['status' => 'error', 'message' => 'Invalid action.'];
//     break;
// }


header('Content-Type: application/json');
echo json_encode($response);
