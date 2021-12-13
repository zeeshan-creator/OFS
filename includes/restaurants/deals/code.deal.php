<?php
ob_start();

// initializing variables
$branchId;
if (isset($_GET['branchId'])) {
   $branchId = trim($_GET['branchId']);
   if ($_SESSION['role'] != 'admin') {
      header("location: restaurantDetails?id=$branchId");
      exit();
   }
} else {
   $branchId = $_SESSION['id'];
}

$restaurantID = $branchId;
$dealName;
$dealPrice;
$dealDesc;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $dealName = mysqli_real_escape_string($conn, trim($_POST['dealName']));
   $dealPrice = mysqli_real_escape_string($conn, trim($_POST['dealPrice']));
   $dealDesc = mysqli_real_escape_string($conn, trim($_POST['dealDesc']));

   // if (!empty($dealName)) {
   //    // first check the database to make sure 
   //    // a deal does not already exist with the same email 
   //    $deal_check_query = "SELECT deal_name FROM deals WHERE deal_name='$dealName' LIMIT 1";
   //    $result = mysqli_query($conn, $deal_check_query);
   //    $deal = mysqli_fetch_assoc($result);

   //    if ($deal) { // if deal exists
   //       if ($deal['name'] == $dealName) {
   //          array_push($errors, "deal name already exists try something else");
   //       }
   //    }
   // }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($dealName)) {
      array_push($errors, "Name is required");
   }

   if (empty($dealPrice)) {
      array_push(
         $errors,
         "price is required"
      );
   }

   if (empty($dealDesc)) {
      array_push($errors, "description is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `deals` 
      (`deal_name`, `deal_price`, `deal_desc`, `active_status`, `created_at`,`restaurant_id`) VALUES
      ('$dealName', '$dealPrice', '$dealDesc', 'active', '$date','$restaurantID')";


      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         $id;
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         header('location: deals');
         exit();
      }
   }
}
