<?php
ob_start();

// initializing variables
$dealID;
$dealName;
$dealPrice;
$dealDesc;
$active_status;
$errors   = array();

if (isset($_POST['action']) && $_POST['action'] == "update") {
   // receive all input values from the form
   $dealID = mysqli_real_escape_string($conn, trim($_POST['dealID']));
   $dealName = mysqli_real_escape_string($conn, trim($_POST['dealName']));
   $dealPrice = mysqli_real_escape_string($conn, trim($_POST['dealPrice']));
   $dealDesc = mysqli_real_escape_string($conn, trim($_POST['dealDesc']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));

   if (!empty($dealName)) {
      // first check the database to make sure 
      // a deal does not already exist with the same name 
      $deal_name_check_query = "SELECT id,deal_name FROM deals WHERE deal_name = '$dealName' LIMIT 1";
      $result = mysqli_query($conn, $deal_name_check_query);
      $deal = mysqli_fetch_assoc($result);

      if ($deal) { // if deal exists
         if ($deal['id'] != $dealID) {
            if ($deal['deal_name'] == $dealName) {
               array_push($errors, "deal name already exists try something else");
            }
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($dealName)) {
      array_push($errors, "Name is required");
   }

   if (empty($dealPrice)) {
      array_push($errors, "price is required");
   }

   if (empty($dealDesc)) {
      array_push($errors, "description is required");
   }

   if (empty($active_status)) {
      array_push(
         $errors,
         "active_status is required"
      );
   }

   // Finally, update if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `deals` SET 
         `deal_name` = '$dealName', 
         `deal_price` = '$dealPrice',
         `deal_desc` = '$dealDesc',
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `deals`.`id` = $dealID";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         echo '<script>window.location.href = "deals";</script>';
         exit();
      }
   }
}
