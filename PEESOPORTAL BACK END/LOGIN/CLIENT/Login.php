<?php
session_start();
require '../UserAuth.php';

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=PEESO;charset=utf8mb4';
$db_username = 'root';
$db_password = '';

// Instantiate UserAuth class
$userAuth = new UserAuth($dsn, $db_username, $db_password);

// Handle form submission
$response = ['authenticated' => false, 'message' => ''];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if ($username && $password) {
        $loginID=$userAuth->authenticate($username, $password);
        if ($loginID) {
            $_SESSION['username'] = $username;
            $response['LoginID']=$loginID;
            $response['authenticated'] = true;
            $response['message'] = 'Login successful. Welcome, ' . htmlspecialchars($username) . '!';
        } else {
            $response['message'] = 'Invalid username or password.';
        }
    } else {
        $response['message'] = 'Both fields are required.';
    }
}
echo json_encode($response);
?>
