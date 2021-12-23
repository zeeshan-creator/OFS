<?php
ob_start();

// initializing variables
$sizeName;
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
   $sizeName = mysqli_real_escape_string($conn, trim($_POST['sizeName']));

   if (!empty($sizeName)) {
      // first check the database to make sure 
      // a size does not already exist with the same email 
      $size_check_query = "SELECT `size` FROM sizes WHERE `size`='$sizeName' LIMIT 1";
      $result = mysqli_query($conn, $size_check_query);
      $size = mysqli_fetch_assoc($result);
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($sizeName)) {
      array_push($errors, "Name is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `sizes` 
      (`size`, `restaurant_id`, `active_status`, `created_at`) VALUES
      ('$sizeName', '$restaurant_id', 'active', '$date')";


      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }
      if ($results) {
         $id;

         header('location: sizes');
         exit();
      }
   }
}
