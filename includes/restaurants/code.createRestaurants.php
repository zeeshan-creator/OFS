<?php
ob_start();

require('./config/db.php');

// initializing variables
$restaurantName;
$restaurantPhone;
$restaurantEmail;
$restaurantPassword;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $restaurantName = mysqli_real_escape_string($conn, trim($_POST['restaurantName']));
   $restaurantPhone = mysqli_real_escape_string($conn, trim($_POST['restaurantPhone']));
   $restaurantEmail = mysqli_real_escape_string($conn, trim($_POST['restaurantEmail']));
   $restaurantPassword = mysqli_real_escape_string($conn, trim($_POST['restaurantPassword']));


   if (!empty($restaurantName)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $restaurant_check_query = "SELECT email FROM restaurants WHERE email='$restaurantEmail' LIMIT 1";
      $result = mysqli_query($conn, $restaurant_check_query);
      $restaurant = mysqli_fetch_assoc($result);


      if ($restaurant) { // if restaurant exists
         if ($restaurant['email'] == $restaurantEmail) {
            array_push($errors, "email already exists try something else");
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($restaurantName)) {
      array_push($errors, "restaurant Name is required");
   }

   if (empty($restaurantPhone)) {
      array_push($errors, "restaurant Phone number is required");
   }

   if (empty($restaurantEmail)) {
      array_push($errors, "restaurant E-Mail is required");
   }

   if (empty($restaurantPassword)) {
      array_push($errors, "restaurant Password is required");
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `restaurants` (`name`, `email`, `password`, `phone`, `role`, `login_status`, `active_status`, `created_at`) VALUES ('$restaurantName', '$restaurantEmail', '$restaurantPassword', '$restaurantPhone', 'main_branch', 'offline', 'active', '$date')";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         echo '<script>window.location.href = "allrestaurants";</script>';
         exit();
      }
   }
}
