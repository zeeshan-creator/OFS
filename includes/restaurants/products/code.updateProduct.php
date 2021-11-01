<?php
ob_start();

// initializing variables
$id;
$productName;
$price;
$description;
$photo;
$active_status;
$item_availability;
$category;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $id = mysqli_real_escape_string($conn, trim($_POST['id']));
   $productName = mysqli_real_escape_string($conn, trim($_POST['productName']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $photo = mysqli_real_escape_string($conn, trim($_POST['photo']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $item_availability = mysqli_real_escape_string($conn, trim($_POST['item_availability']));
   $category = mysqli_real_escape_string($conn, trim($_POST['category']));

   if (!empty($productName)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $product_name_check_query = "SELECT name,id FROM products WHERE name = '$productName' LIMIT 1";
      $result = mysqli_query($conn, $product_name_check_query);
      $product = mysqli_fetch_assoc($result);

      if ($product) { // if product exists
         if ($product['id'] != $id) {
            if ($product['name'] == $productName) {
               array_push($errors, "product name already exists try something else");
            }
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($productName)) {
      array_push($errors, "Name is required");
   }

   if (empty($price)) {
      array_push($errors, "price is required");
   }

   if (empty($description)) {
      array_push($errors, "description is required");
   }

   if (empty($photo)) {
      array_push(
         $errors,
         "photo is required"
      );
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
         WHERE `products`.`id` = $id";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         echo '<script>window.location.href = "products";</script>';
         exit();
      }
   }
}
