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
$offer_name;
$offer_percentage;
$offer_message;
$order_over;
$valid_from;
$valid_till;

$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $offer_name = mysqli_real_escape_string($conn, trim($_POST['offer_name']));
   $offer_percentage = mysqli_real_escape_string($conn, trim($_POST['offer_percentage']));
   $offer_message = mysqli_real_escape_string($conn, trim($_POST['offer_message']));
   $order_over = mysqli_real_escape_string($conn, trim($_POST['order_over']));
   $valid_from = mysqli_real_escape_string($conn, trim($_POST['valid_from']));
   $valid_till = mysqli_real_escape_string($conn, trim($_POST['valid_till']));

   if (!empty($offer_name)) {
      // first check the database to make sure 
      // a offer does not already exist with the same offer 
      $offer_check_query = "SELECT offer_name FROM offers WHERE offer_name='$offer_name' LIMIT 1";
      $result = mysqli_query($conn, $offer_check_query);
      $offer = mysqli_fetch_assoc($result);

      if ($offer) { // if offer exists
         if ($offer['name'] == $offer_name) {
            array_push($errors, "offer name already exists try something else");
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($offer_name)) {
      array_push($errors, "Name is required");
   }

   if (empty($offer_percentage)) {
      array_push(
         $errors,
         "percentage is required"
      );
   }

   if (empty($offer_message)) {
      array_push($errors, "message is required");
   }

   if (empty($valid_from)) {
      array_push($errors, "start date is required");
   }

   if (empty($valid_till)) {
      array_push($errors, "end date is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `offers`(`offer_name`, `offer_percentage`, `offer_message`, `order_over`, `valid_from`, `valid_till`, `active_status`, `restaurant_id`, `created_at`) VALUES ('$offer_name','$offer_percentage','$offer_message','$order_over','$valid_from','$valid_till','active','$restaurantID','$date')";

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
         header('location: offers');
         exit();
      }
   }
}
