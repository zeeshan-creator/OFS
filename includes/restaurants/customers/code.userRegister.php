<?php
ob_start();
session_start();

require('./config/db.php');

// initializing variables
$name;
$email;
$password;
$phone;
$address;
$errors   = array();

if (!isset($_GET['branchID']) || $_GET['branchID'] == '' || $_GET['branchID'] == null) {
   echo "branchID is missing from the url parameters";
   exit;
} else {
   $branchID = $_GET['branchID'];
}

if (isset($_SESSION['branchID'])) {
   header("Location: order_now?id=" . $_SESSION['branchID']);
   exit();
}

// REGISTER USER
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error unto $errors array
   if (empty($name)) {
      array_push($errors, "Name is required");
   }
   if (empty($email)) {
      array_push($errors, "Email is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }
   if (empty($phone)) {
      array_push($errors, "Phone is required");
   }
   if (empty($address)) {
      array_push($errors, "address is required");
   }

   // first check the database to make sure 
   // a user does not already exist with the same email 
   $user_check_query = "SELECT * FROM customers WHERE email='$email' LIMIT 1";
   $result = mysqli_query($conn, $user_check_query);
   $user = mysqli_fetch_assoc($result);

   if ($user) { // if user exists
      if ($user['email'] === $email) {
         array_push($errors, "email already exists");
      }
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {
      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `customers`(
                  `full_name`,
                  `email`,
                  `password`,
                  `phone`,
                  `address`,
                  `status`,
                  `restaurant_id`,
                  `created_at`
                  ) VALUES (
                  '$name',
                  '$email',
                  '$password',
                  '$phone',
                  '$address',
                  'active',
                  '$branchID',
                  '$date')";
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($result) {
         echo '<script>window.location.href = "userLogin";</script>';
         exit();
      }
   }
}
