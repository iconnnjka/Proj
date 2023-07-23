<?php
session_start();

// initializing variables
$email = "";
$errors = array(); 

// connect to the database
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, "./DigiCertTLSECCP384RootG5.crt.pem", NULL, NULL);
$db = mysqli_real_connect($conn, 'xacbank.database.windows.net', 'sugallr', 'mkN@C92chYS7vjU', 'xac_fuck_up', 3306, NULL, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    $user_check_query = "SELECT * FROM SUGA_LLR WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
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
