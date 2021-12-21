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
   $name = mysqli_real_escape_string($conn, trim($_POST['name']));
   $description = mysqli_real_escape_string($conn, trim($_POST['description']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));

   if (!empty($sizeName)) {
      // first check the database to make sure 
      // a size does not already exist with the same email 
      // $size_check_query = "SELECT `size` FROM sizes WHERE `size`='$sizeName' LIMIT 1";
      // $result = mysqli_query($conn, $size_check_query);
      // $size = mysqli_fetch_assoc($result);

      // if ($size) { // if size exists
      //    if ($size['size'] == $sizeName) {
      //       array_push($errors, "Size name already exists try something else");
      //    }
      // }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($name)) {
      array_push(
         $errors,
         "Addon Name is required"
      );
   }

   if (empty($description)) {
      array_push($errors, "Addon description is required");
   }

   if (empty($price)) {
      array_push(
         $errors,
         "Addon price is required"
      );
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `addons_products` 
      (`name`, `restaurant_id`, `price`, `description`, `active_status`, `created_at`) VALUES
      ('$name', '$restaurant_id', '$price', '$description', 'active', '$date')";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }
      if ($results) {
         header('location: addon_products');
         exit();
      }
   }
}
