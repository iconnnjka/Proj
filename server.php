<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'xac_fuck_up');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);

  if (empty($email)) { array_push($errors, "Email is required"); }

  $user_check_query = "SELECT * FROM SUGA_LLR WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) {
  	$query = "INSERT INTO SUGA_LLR (email) 
  			  VALUES('$email')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
?>