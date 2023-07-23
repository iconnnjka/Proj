<?php
session_start();

// initializing variables
$email = "";
$errors = array(); 

// connect to the database
// $db = mysqli_real_connect($conn, 'xacbank.database.windows.net', 'sugallr', 'mkN@C92chYS7vjU', 'xac_fuck_up', 3306, NULL, MYSQLI_CLIENT_SSL);

try {
  $conn = new PDO("sqlsrv:server = tcp:xacbank.database.windows.net,1433; Database = xac_fuck_up", "sugallr", "mkN@C92chYS7vjU");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
  print("Error connecting to SQL Server.");
  die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "sugallr", "pwd" => "mkN@C92chYS7vjU", "Database" => "xac_fuck_up", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:xacbank.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    $user_check_query = "SELECT * FROM SUGA_LLR WHERE email='$email' LIMIT 1";
    $result = sqlsrv_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
  
    if ($user) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO SUGA_LLR (email) 
                  VALUES('$email')";
        mysqli_query($conn, $query);
        $_SESSION['success'] = "You are now registered";
        header('location: index.php');
    }
}
?>
