<?php
session_start();

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
    echo "gg";
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Register User
if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']); // Assuming you have an input field named 'password'

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    if (count($errors) == 0) {
        // Use prepared statements for both email and password
        $query = "INSERT INTO SUGA_LLR (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);

        $_SESSION['success'] = "You are now registered";
        header('location: success.php'); // Redirect to a success page on your website
        exit();
    }
}

// Close the database connection when you're done
mysqli_close($conn);
?>
