<?php
ob_start();

// initializing variables
$size_name;
$active_status;
$sizeId;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $size_name = mysqli_real_escape_string($conn, trim($_POST['size_name']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $sizeId = mysqli_real_escape_string($conn, trim($_POST['sizeId']));

   if (!empty($size_name)) {
      // first check the database to make sure 
      // a size does not already exist with the same size 
      $size_name_check_query = "SELECT size, id, restaurant_id FROM sizes WHERE `size`='$size_name' LIMIT 1";
      $result = mysqli_query($conn, $size_name_check_query);
      $size = mysqli_fetch_assoc($result);
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($size_name)) {
      array_push($errors, "size Name is required");
   }

   if (empty($active_status)) {
      array_push($errors, "active status is required");
   }

   // Finally, save size if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `sizes` SET 
         `size` = '$size_name', 
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `sizes`.`id` = $sizeId";

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
         echo '<script>window.location.href = "sizes";</script>';
         exit();
      }
   }
}
