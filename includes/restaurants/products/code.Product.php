<?php
ob_start();


// initializing variables
$productName;
$price;
$description;
$photo;
$category;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $productName = mysqli_real_escape_string($conn, trim($_POST['productName']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $photo = mysqli_real_escape_string($conn, trim($_POST['photo']));
   $category = mysqli_real_escape_string($conn, trim($_POST['category']));

   if (!empty($productName)) {
      // first check the database to make sure 
      // a product does not already exist with the same email 
      $product_check_query = "SELECT name FROM products WHERE name='$productName' LIMIT 1";
      $result = mysqli_query($conn, $product_check_query);
      $product = mysqli_fetch_assoc($result);

      if ($product) { // if product exists
         if ($product['name'] == $productName) {
            array_push($errors, "product name already exists try something else");
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($productName)) {
      array_push($errors, "Name is required");
   }

   if (empty($price)) {
      array_push(
         $errors,
         "price is required"
      );
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

   if (empty($category)) {
      array_push(
         $errors,
         "category is required"
      );
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `products` 
      (`name`, `price`, `description`, `photo`, `category_id`, `created_at`) VALUES
      ('$productName', '$price', '$description', '$photo', '$category', '$date')";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         header('location: products');
         exit();
      }
   }
}
