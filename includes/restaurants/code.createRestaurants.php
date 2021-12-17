<?php
ob_start();

// initializing variables
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
   $target_dir = "includes/restaurants/logos/";
   $target_file = $target_dir;
   $filename = $_FILES["logo"]["name"];


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
   $check = getimagesize($_FILES["logo"]["tmp_name"]);
   if ($check == false) {
      array_push($errors, "File is not an image");
   }

   // Check if file already exists
   // if (file_exists($target_file)) {
   //    array_push($errors, "Sorry, file already exists");
   // }

   // Check file size
   if ($_FILES["logo"]["size"] > 1000000) {
      array_push($errors, "Sorry, your file is too large");
   }

   // Allow certain file formats
   $imageFileType = strtolower(pathinfo(basename($_FILES["logo"]["name"]), PATHINFO_EXTENSION));
   if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
   }

   if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file . $restaurantEmail . "." . $imageFileType)) {
      array_push($errors, "Sorry, there was an error uploading your file");
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
      $query = "INSERT INTO `restaurants` (`name`, `email`, `logo`, `password`, `phone`, `contact_name`, `contact_phone`, `contact_email`, `country`, `city`, `street_address`, `cuisine`, `role`, `login_status`, `active_status`, `created_at`) VALUES ('$restaurantName', '$restaurantEmail', '$restaurantEmail.$imageFileType', '$restaurantPassword', '$restaurantPhone', '$contact_name', '$contact_phone',  '$contact_email', '$country', '$city', '$street_address', '$cuisine', 'main_branch', 'offline', 'active', '$date')";

      $results = mysqli_query($conn, $query)  or die(mysqli_error($conn));

      if ($results) {
         echo '<script>window.location.href = "allrestaurants";</script>';
         exit();
      }
   }
}
