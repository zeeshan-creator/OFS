<?php
ob_start();

// require('./config/db.php');

// initializing variables
$restaurantId;
$restaurantName;
$restaurantPhone;
$restaurantEmail;
$restaurantPassword;
$contact_name;
$contact_phone;
$contact_email;
$country;
$logo;
$oldLogo;
$city;
$street_address;
$cuisine;
$errors = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $restaurantId = mysqli_real_escape_string($conn, trim($_POST['restaurantId']));
   $restaurantName = mysqli_real_escape_string($conn, trim($_POST['restaurantName']));
   $restaurantPhone = mysqli_real_escape_string($conn, trim($_POST['restaurantPhone']));
   $restaurantEmail = mysqli_real_escape_string($conn, trim($_POST['restaurantEmail']));
   $restaurantPassword = mysqli_real_escape_string($conn, trim($_POST['restaurantPassword']));
   $contact_name = mysqli_real_escape_string($conn, trim($_POST['contact_name']));
   $contact_phone = mysqli_real_escape_string($conn, trim($_POST['contact_phone']));
   $contact_email = mysqli_real_escape_string($conn, trim($_POST['contact_email']));
   $country = mysqli_real_escape_string($conn, trim($_POST['country']));
   $city = mysqli_real_escape_string($conn, trim($_POST['city']));
   $oldLogo = mysqli_real_escape_string($conn, trim($_POST['oldLogo']));
   $street_address = mysqli_real_escape_string($conn, trim($_POST['street_address']));
   $cuisine = mysqli_real_escape_string($conn, trim($_POST['cuisine']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));

   if (!empty($restaurantEmail)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $restaurant_check_query = "SELECT email,id FROM restaurants WHERE email='$restaurantEmail' LIMIT 1";
      $result = mysqli_query($conn, $restaurant_check_query);
      $restaurant = mysqli_fetch_assoc($result);

      if ($restaurant) { // if restaurant exists
         if ($restaurant['id'] != $restaurantId) {
            if ($restaurant['email'] == $restaurantEmail) {
               array_push($errors, "email already exists try something else");
            }
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (basename($_FILES["newLogo"]["name"]) != '' && basename($_FILES["newLogo"]["name"]) != null) {
      $target_dir = "includes/restaurants/logos/";

      $check = getimagesize($_FILES["newLogo"]["tmp_name"]);
      if ($check == false) {
         array_push($errors, "File is not an image");
      }

      // Check file size
      if ($_FILES["newLogo"]["size"] > 1000000) { // 1000KB is 1MB
         array_push($errors, "Sorry, your file is too large");
      }

      // Allow certain file formats
      $imageFileType = strtolower(pathinfo(basename($_FILES["newLogo"]["name"]), PATHINFO_EXTENSION));
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
         array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
      }

      if (!move_uploaded_file($_FILES["newLogo"]["tmp_name"], $target_dir . ($restaurantEmail . "." . $imageFileType))) {
         array_push($errors, "Sorry, there was an error uploading your file");
      }

      $logo = $restaurantEmail . "." . $imageFileType;
   }

   if (basename($_FILES["newLogo"]["name"]) == '' && basename($_FILES["newLogo"]["name"]) == null) {
      $logo = $oldLogo;
   }

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
      array_push($errors, "city is required");
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
      $query = "UPDATE `restaurants` SET 
            `name` = '$restaurantName',
            `phone` = '$restaurantPhone',
            `email` = '$restaurantEmail',
            `password` = '$restaurantPassword',
            `logo` = '$logo',
            `contact_name` = '$contact_name',
            `contact_phone` = '$contact_phone',
            `contact_email` = '$contact_email',
            `country` = '$country',
            `city` = '$city',
            `street_address` = '$street_address',
            `cuisine` = '$cuisine',
            `active_status` = '$active_status',
            `updated_at` = '$date'
            WHERE `restaurants`.`id` = $restaurantId";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         echo '<script>window.location.href = "allrestaurants";</script>';
         exit();
      }
   }
}
