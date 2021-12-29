<?php
ob_start();

// initializing variables
$zoneName;

$restaurant_id;
if (isset($_GET['branchId'])) {
   $id = trim($_GET['branchId']);
   if ($_SESSION['role'] == 'admin') {
      $restaurant_id = trim($_GET['branchId']);
   }
} else {
   $restaurant_id = $_SESSION['id'];
}

$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $zoneName = mysqli_real_escape_string($conn, trim($_POST['zoneName']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($zoneName)) {
      array_push($errors, "zone name is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');

      $query = "UPDATE `delivery_zone` SET `zone_name`='$zoneName', `created_at`='$date' WHERE `restaurant_id` = $restaurant_id";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }
      if ($results) {
         header('location: branchSettings');
         exit();
      }
   }
}
