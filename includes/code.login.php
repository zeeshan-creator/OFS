<?php
ob_start();
session_start();

require('./config/db.php');


// initializing variables
$email;
$password;
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

   $query = "SELECT * FROM admin WHERE email='$email' limit 1";
   $adminResults = mysqli_query($conn, $query);

   if (mysqli_num_rows($adminResults) == 1) {
      $row = mysqli_fetch_assoc($adminResults);
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }
      if ($row["password"] == $password) {
         if ($row["active_status"] !== "active") {
            array_push($errors, "Your Account is Not Inactive Please Contact the administration");
         }
      }

      if (count($errors) == 0) {
         $query = "SELECT * FROM admin WHERE email='$email'";
         $results = mysqli_query($conn, $query);
         if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_assoc($results);
            $_SESSION['name'] = $row["name"];
            $_SESSION['role'] = $row["role"];
            header('location: index');
            exit();
         } else {
            array_push($errors, "Wrong email/password combination");
         }
      }
   } else {
      $query = "SELECT * FROM restaurants WHERE email='$email' limit 1";
      $bracnhResults = mysqli_query($conn, $query);

      if (mysqli_num_rows($bracnhResults) == 1) {
         $row = mysqli_fetch_assoc($bracnhResults);
         if ($row["password"] !== $password) {
            array_push($errors, "Password is Wrong");
         }
         if ($row["password"] == $password) {
            if ($row["active_status"] !== "active") {
               array_push($errors, "Your Account is Not Inactive Please Contact the administration");
            }
         }
         if (count($errors) == 0) {
            $query = "SELECT * FROM restaurants WHERE email='$email'";
            $results = mysqli_query($conn, $query);
            if (mysqli_num_rows($results) == 1) {
               $row = mysqli_fetch_assoc($results);
               $_SESSION['name'] = $row["name"];
               $_SESSION['role'] = $row["role"];
               header('location: index');
               exit();
            } else {
               array_push($errors, "Wrong email/password combination");
            }
         }
      }
   }
   if (count($errors) == 0) {
      if (!empty($email) && !empty($password)) {
         array_push($errors, "Your Email Does Not Exist");
      }
   }
}
ob_end_flush();

// ...
