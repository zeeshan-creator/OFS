<?php
ob_start();

// initializing variables
$name;
$description;
$price;
$active_status;
$photo;
$oldImage;
$addonId;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $name = mysqli_real_escape_string($conn, trim($_POST['name']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $oldImage = mysqli_real_escape_string($conn, trim($_POST['oldImage']));
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
   if (
      basename($_FILES["newImage"]["name"]) != '' && basename($_FILES["newImage"]["name"]) != null
   ) {
      $target_dir = "includes/restaurants/addon_products/addons_imgs/";

      $check = getimagesize($_FILES["newImage"]["tmp_name"]);
      if ($check == false) {
         array_push($errors, "File is not an image");
      }

      // Check file size
      if ($_FILES["newImage"]["size"] > 1000000) { // 1000KB is 1MB
         array_push($errors, "Sorry, your file is too large");
      }

      // Allow certain file formats
      $imageFileType = strtolower(pathinfo(basename($_FILES["newImage"]["name"]), PATHINFO_EXTENSION));
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
         array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
      }

      if (!move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_dir . ($oldImage))) {
         array_push($errors, "Sorry, there was an error uploading your file");
      }

      $photo = $oldImage;
   }

   if (
      basename($_FILES["newImage"]["name"]) == '' && basename($_FILES["newImage"]["name"]) == null
   ) {
      $photo = $oldImage;
   }

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
         `photo` = '$photo',
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
