<?php
ob_start();

require('./config/db.php');

session_start();

// initializing variables
$email    = "";
$password = "";
$errors   = array();


if (isset($_SESSION['name'])) {
   header("Location: index");

   exit();
}

// LOGIN USER
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   if (empty($email)) {
      array_push($errors, "Email is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }

   // $password = md5($password);
   $query = "SELECT * FROM admin WHERE email='$email'";
   $results = mysqli_query($conn, $query);

   if (mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }
   } else {
      array_push($errors, "Your Email Does Not Exist");
   }

   if (count($errors) == 0) {
      // $password = md5($password);
      $query = "SELECT * FROM admin WHERE email='$email'";
      $results = mysqli_query($conn, $query);
      if (mysqli_num_rows($results) == 1) {
         $row = mysqli_fetch_assoc($results);
         $_SESSION['name'] = $row["name"];
         header('location: index');
         exit();
      } else {
         array_push($errors, "Wrong email/password combination");
      }
   }
}
ob_end_flush();

// ...
