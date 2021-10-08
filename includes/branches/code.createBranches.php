<?php
ob_start();

require('./config/db.php');

// initializing variables
$branchName;
$branchPhone;
$branchEmail;
$branchPassword;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $branchName = mysqli_real_escape_string($conn, trim($_POST['branchName']));
   $branchPhone = mysqli_real_escape_string($conn, trim($_POST['branchPhone']));
   $branchEmail = mysqli_real_escape_string($conn, trim($_POST['branchEmail']));
   $branchPassword = mysqli_real_escape_string($conn, trim($_POST['branchPassword']));


   if (!empty($branchName)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $branch_check_query = "SELECT email FROM branches WHERE email='$branchEmail' LIMIT 1";
      $result = mysqli_query($conn, $branch_check_query);
      $branch = mysqli_fetch_assoc($result);


      if ($branch) { // if branch exists
         if ($branch['email'] == $branchEmail) {
            array_push($errors, "email already exists try something else");
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($branchName)) {
      array_push($errors, "Branch Name is required");
   }

   if (empty($branchPhone)) {
      array_push($errors, "Branch Phone number is required");
   }

   if (empty($branchEmail)) {
      array_push($errors, "Branch E-Mail is required");
   }

   if (empty($branchPassword)) {
      array_push($errors, "Branch Password is required");
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `branches` (`name`, `email`, `password`, `phone`, `role`, `login_status`, `active_status`, `created_at`) VALUES ('$branchName', '$branchEmail', '$branchPassword', '$branchPhone', 'main_branch', 'offline', 'active', '$date')";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         header('location: allbranches');
         exit();
      }
   }
}
