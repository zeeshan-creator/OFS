<?php
ob_start();

// initializing variables
$name;
$description;
$price;
$active_status;
$addonId;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $name = mysqli_real_escape_string($conn, trim($_POST['name']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $addonId = mysqli_real_escape_string($conn, trim($_POST['addonId']));

   if (!empty($name)) {
      // first check the database to make sure 
      // a size does not already exist with the name size 
      // $name_check_query = "SELECT name, id, restaurant_id FROM sizes WHERE `size`='$name' LIMIT 1";
      // $result = mysqli_query($conn, $name_check_query);
      // $size = mysqli_fetch_assoc($result);
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($name)) {
      array_push($errors, "Addon Name is required");
   }

   if (empty($description)) {
      array_push($errors, "Addon description is required");
   }

   if (empty($price)) {
      array_push($errors, "Addon price is required");
   }

   if (empty($active_status)) {
      array_push($errors, "active status is required");
   }

   // Finally, save size if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `addons_products` SET 
         `name` = '$name', 
         `description` = '$description', 
         `price` = '$price', 
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `id` = $addonId";

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
         echo '<script>window.location.href = "addon_products";</script>';
         exit();
      }
   }
}
