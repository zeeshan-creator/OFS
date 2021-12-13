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
$id;
$offer_name;
$offer_percentage;
$offer_message;
$order_over;
$valid_from;
$valid_till;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $offer_id = mysqli_real_escape_string($conn, trim($_POST['offerID']));
   $offer_name = mysqli_real_escape_string($conn, trim($_POST['offer_name']));
   $offer_percentage = mysqli_real_escape_string($conn, trim($_POST['offer_percentage']));
   $offer_message = mysqli_real_escape_string($conn, trim($_POST['offer_message']));
   $order_over = mysqli_real_escape_string($conn, trim($_POST['order_over']));
   $valid_from = mysqli_real_escape_string($conn, trim($_POST['valid_from']));
   $valid_till = mysqli_real_escape_string($conn, trim($_POST['valid_till']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));

   // if (!empty($offer_name)) {
   //    // first check the database to make sure 
   //    // a offer does not already exist with the same offer 
   //    $offer_name_check_query = "SELECT offer_name, id FROM offers WHERE `offer_name`='$offer_name' LIMIT 1";
   //    $result = mysqli_query($conn, $offer_name_check_query);
   //    $offer = mysqli_fetch_assoc($result);
   //    if ($offer) { // if offer exists
   //       if ($offer['id'] != $offer_id) {
   //          if ($offer['offer_name'] == $offer_name) {
   //             array_push($errors, "offer name already exists try something else");
   //          }
   //       }
   //    }
   // }

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

   if (empty($active_status)) {
      array_push($errors, "active status is required");
   }

   // Finally, save offer if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `offers` SET 
         `offer_name` = '$offer_name',
         `offer_percentage` = '$offer_percentage',
         `offer_message` = '$offer_message',
         `order_over` = '$order_over',
         `valid_from` = '$valid_from',
         `valid_till` = '$valid_till',
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `id` = '$offer_id'";

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
         echo '<script>window.location.href = "offers";</script>';
         exit();
      }
   }
}
