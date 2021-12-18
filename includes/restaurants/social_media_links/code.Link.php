<?php
ob_start();

// initializing variables
$name;
$link;
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
   $name = mysqli_real_escape_string($conn, trim($_POST['name']));
   $link = mysqli_real_escape_string($conn, trim($_POST['link']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($name)) {
      array_push($errors, "Name is required");
   }
   if (empty($link)) {
      array_push(
         $errors,
         "Link is required"
      );
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `social_media_links` 
      (`name`, `link`, `restaurant_id`, `active_status`, `created_at`) VALUES
      ('$name', '$link', '$restaurant_id', 'active', '$date')";


      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }
      if ($results) {
         header('location: social_media_links');
         exit();
      }
   }
}
