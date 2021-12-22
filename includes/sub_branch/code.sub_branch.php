<?php
ob_start();

// require('./config/db.php');

// initializing variables

$branchId;
if (isset($_GET['branchId'])) {
   $branchId = trim($_GET['branchId']);
   if ($_SESSION['role'] != 'admin') {
      header("location: restaurantDetails?id=$branchId");
      exit();
   }
}

$restaurantName;
$restaurantPhone;
$restaurantEmail;
$restaurantPassword;
$contact_name;
$contact_phone;
$contact_email;
$country;
$city;
$street_address;
$cuisine;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $restaurantName = mysqli_real_escape_string($conn, trim($_POST['restaurantName']));
   $restaurantPhone = mysqli_real_escape_string($conn, trim($_POST['restaurantPhone']));
   $restaurantEmail = mysqli_real_escape_string($conn, trim($_POST['restaurantEmail']));
   $restaurantPassword = mysqli_real_escape_string($conn, trim($_POST['restaurantPassword']));
   $contact_name = mysqli_real_escape_string($conn, trim($_POST['contact_name']));
   $contact_phone = mysqli_real_escape_string($conn, trim($_POST['contact_phone']));
   $contact_email = mysqli_real_escape_string($conn, trim($_POST['contact_email']));
   $country = mysqli_real_escape_string($conn, trim($_POST['country']));
   $city = mysqli_real_escape_string($conn, trim($_POST['city']));
   $street_address = mysqli_real_escape_string($conn, trim($_POST['street_address']));
   $cuisine = mysqli_real_escape_string($conn, trim($_POST['cuisine']));

   // if (!empty($restaurantName)) {
   //    // first check the database to make sure 
   //    // a user does not already exist with the same email 
   //    $restaurant_check_query = "SELECT email FROM restaurants WHERE email='$restaurantEmail' LIMIT 1";
   //    $result = mysqli_query($conn, $restaurant_check_query);
   //    $restaurant = mysqli_fetch_assoc($result);


   //    if ($restaurant) { // if restaurant exists
   //       if ($restaurant['email'] == $restaurantEmail) {
   //          array_push($errors, "email already exists try something else");
   //       }
   //    }
   // }

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

   if (empty($contact_name)) {
      array_push($errors, "contact name is required");
   }

   if (empty($contact_phone)) {
      array_push($errors, "contact phone is required");
   }

   if (empty($contact_email)) {
      array_push($errors, "contact email is required");
   }

   if (empty($country)) {
      array_push($errors, "country is required");
   }

   if (empty($city)) {
      array_push(
         $errors,
         "city is required"
      );
   }

   if (empty($street_address)) {
      array_push($errors, "street address is required");
   }

   if (empty($cuisine)) {
      array_push($errors, "cuisine is required");
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `sub_restaurants` (
               `name`,
               `email`, 
               `password`, 
               `phone`, 
               `contact_name`, 
               `contact_phone`, 
               `contact_email`, 
               `country`,
               `city`, 
               `street_address`, 
               `cuisine`,
               `role`, 
               `login_status`, 
               `active_status`, 
               `created_at`, 
               `main_branch` 
               ) VALUES (
               '$restaurantName', 
               '$restaurantEmail', 
               '$restaurantPassword', 
               '$restaurantPhone', 
               '$contact_name',  
               '$contact_phone', 
               '$contact_email', 
               '$country',  
               '$city', 
               '$street_address', 
               '$cuisine', 
               'sub_branch', 
               'offline', 
               'active',  
               '$date', 
               $branchId 
               )";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         header('location: allrestaurants');
         exit();
      }
   }
}
