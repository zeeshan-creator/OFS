<?php
ob_start();

// initializing variables
$productName;
$price;
$description;
$category;
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $productName = mysqli_real_escape_string($conn, trim($_POST['productName']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $category = mysqli_real_escape_string($conn, trim($_POST['category']));
   $target_dir = "includes/restaurants/products/product_imgs/";
   $target_file = $target_dir . basename($_FILES["photo"]["name"]);
   $filename = $_FILES["photo"]["name"];

   // if (!empty($productName)) {
   //    // first check the database to make sure 
   //    // a product does not already exist with the same email 
   //    $product_check_query = "SELECT name, id FROM products WHERE name='$productName' LIMIT 1";
   //    $result = mysqli_query($conn, $product_check_query);
   //    $product = mysqli_fetch_assoc($result);

   //    if ($product) { // if product exists
   //       if ($product['id'] != $productID) {
   //          if ($product['name'] == $productName) {
   //             array_push($errors, "product name already exists try something else");
   //          }
   //       }
   //    }
   // }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   $check = getimagesize($_FILES["photo"]["tmp_name"]);
   if ($check == false) {
      array_push($errors, "File is not an image");
   }

   // Check if file already exists
   // if (file_exists($target_file)) {
   //    array_push($errors, "Sorry, file already exists");
   // }

   // Check file size
   if ($_FILES["photo"]["size"] > 500000) {
      array_push($errors, "Sorry, your file is too large");
   }

   // Allow certain file formats
   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
   }

   if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
      array_push($errors, "Sorry, there was an error uploading your file");
   }

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
      ('$productName', '$price', '$description', '$filename', '$category', '$date')";


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
         header('location: products');
         exit();
      }
   }
}
