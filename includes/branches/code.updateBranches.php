<?php
ob_start();

require('./config/db.php');

// initializing variables
$branchId;
$branchName;
$branchPhone;
$branchEmail;
$branchPassword;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $branchId = mysqli_real_escape_string($conn, trim($_POST['branchId']));
   $branchName = mysqli_real_escape_string($conn, trim($_POST['branchName']));
   $branchPhone = mysqli_real_escape_string($conn, trim($_POST['branchPhone']));
   $branchEmail = mysqli_real_escape_string($conn, trim($_POST['branchEmail']));
   $branchPassword = mysqli_real_escape_string($conn, trim($_POST['branchPassword']));
   $role = mysqli_real_escape_string($conn, trim($_POST['role']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));

   if (!empty($branchEmail)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $branch_check_query = "SELECT email,id FROM branches WHERE email='$branchEmail' LIMIT 1";
      $result = mysqli_query($conn, $branch_check_query);
      $branch = mysqli_fetch_assoc($result);

      if ($branch) { // if branch exists
         if ($branch['id'] != $branchId) {
            if ($branch['email'] == $branchEmail) {
               array_push($errors, "email already exists try something else");
            }
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
      $query = "UPDATE `branches` SET `name` = '$branchName',`phone` = '$branchPhone',`email` = '$branchEmail',`password` = '$branchPassword',`role` = '$role',`active_status` = '$active_status' WHERE `branches`.`id` = $branchId";



      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         header('location: allbranches');
         exit();
      }
   }
}
