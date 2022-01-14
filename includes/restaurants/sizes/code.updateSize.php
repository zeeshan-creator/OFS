<?php
ob_start();

// initializing variables
$size_name;
$price;
$sizeId;
$productID= $_GET['productID'];
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $size_name = mysqli_real_escape_string($conn, trim($_POST['size_name']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $sizeId = mysqli_real_escape_string($conn, trim($_POST['sizeId']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($size_name)) {
      array_push($errors, "size Name is required");
   }

   if (empty($price)) {
      array_push($errors, "active status is required");
   }

   // Finally, save size if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `sizes` SET 
         `size` = '$size_name', 
         `price` = '$price',
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
         echo '<script>window.location.href = "update.products?productID="'.';</script>';
         exit();
      }
   }
}
