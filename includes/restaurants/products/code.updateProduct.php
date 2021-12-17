<?php
ob_start();

// initializing variables
$productID;
$productName;
$price;
$description;
$photo;
$oldImage;
$active_status;
$item_availability;
$category;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $productID = mysqli_real_escape_string($conn, trim($_POST['productID']));
   $productName = mysqli_real_escape_string($conn, trim($_POST['productName']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $oldImage = mysqli_real_escape_string($conn, trim($_POST['oldImage']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $item_availability = mysqli_real_escape_string($conn, trim($_POST['item_availability']));
   $category = mysqli_real_escape_string($conn, trim($_POST['category']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (basename($_FILES["newImage"]["name"]) != '' && basename($_FILES["newImage"]["name"]) != null) {
      $target_dir = "includes/restaurants/products/product_imgs/";

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

   if (empty($productName)) {
      array_push($errors, "Name is required");
   }

   if (empty($price)) {
      array_push($errors, "price is required");
   }

   if (empty($description)) {
      array_push($errors, "description is required");
   }

   if (empty($active_status)) {
      array_push(
         $errors,
         "active_status is required"
      );
   }
   if (empty($item_availability)) {
      array_push(
         $errors,
         "item availability is required"
      );
   }
   if (empty($category)) {
      array_push(
         $errors,
         "category is required"
      );
   }

   // Finally, update if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `products` SET 
         `name` = '$productName', 
         `price` = '$price',
         `description` = '$description',
         `photo` = '$photo',
         `active_status` = '$active_status',
         `item_availability` = '$item_availability',
         `category_id` = '$category',
         `updated_at` = '$date'
         WHERE `products`.`id` = $productID";

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
         echo '<script>window.location.href = "products";</script>';
         exit();
      }
   }
}
