<?php
ob_start();
session_start();

require('./config/db.php');

// initializing variables
$email;
$password;
$errors   = array();

if (isset($_SESSION['branchID'])) {
   header('Location: order_now?id=' . $_SESSION['branchID']);
   exit();
}

if (isset($_GET['branchID'])) {
   $branchID = $_GET['branchID'];
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

   $query = "SELECT * FROM customers WHERE email='$email' limit 1";
   $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
   $row = mysqli_fetch_assoc($results);

   if (mysqli_num_rows($results) == 1) {
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }

      if ($row["password"] == $password) {
         if ($row["status"] !== "active") {
            array_push($errors, "Your Account is Not Inactive, Please Contact the Administration");
         }
      }

      if (count($errors) == 0) {
         $query = "SELECT * FROM `customers` WHERE email='$email' LIMIT 1";
         $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

         if (mysqli_num_rows($results) == 1) {
            $_SESSION['userName'] = $row["full_name"];
            $_SESSION['userEmail'] = $row["email"];
            $_SESSION['branchID'] = $row["restaurant_id"];
            $_SESSION['userId'] = $row["id"];
            $_SESSION['userStatus'] = $row["active_status"];
            header('Location: order_now?id=' . $row["restaurant_id"]);
            exit();
         }
      }
   } else {
      array_push($errors, "Email doesn't exist");
   }
}
