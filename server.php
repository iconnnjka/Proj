<?php
session_start();

// initializing variables
$email = "";
$errors = array(); 

// connect to the database
$db_host = 'xacbankk-server.mysql.database.azure.com';
$db_user = 'okyzwjplcj';
$db_pass = '04883YR7V1S12110$';
$db_name = 'xacbankk-database';
$db_port = 3306;

// Enable SSL for the connection
$ssl_ca = './DigiCertGlobalRootCA.crt.pem'; // Replace with the correct path to your SSL CA certificate file

// Establish a secure SSL-encrypted connection to the database
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);
mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// REGISTER USER
// if (isset($_POST['reg_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    // Use prepared statements to prevent SQL injection
    // $user_check_query = "SELECT * FROM SUGA_LLR WHERE email = ?";
    // $stmt = mysqli_prepare($conn, $user_check_query);
    // mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    // mysqli_stmt_execute($stmt);
    // $result = mysqli_stmt_get_result($stmt);
    // $user = mysqli_fetch_assoc($result);
  
    // if ($user) { // if user exists
    //     if ($user['email'] === $email) {
    //         array_push($errors, "Email already exists");
    //     }
    // }

    if (count($errors) == 0) {
        // Use prepared statements for the INSERT query as well
        $query = "INSERT INTO SUGA_LLR (email, password) VALUES(?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);

        $_SESSION['success'] = "You are now registered";
        echo "<script>window.location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';</script>";
        header('location: index.php');
    }
// }
