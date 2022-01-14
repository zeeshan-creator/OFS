<?php
// include '../auth/login_auth.php';
// include '../../../config/db.php';

// session_start();
ob_start();

// initializing variables
$sizeName;
$price;
$productID;

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

if (isset($_POST['action']) && $_POST['action'] == "addSize") {
   // receive all input values from the form
   $sizeName = mysqli_real_escape_string($conn, trim($_POST['sizeName']));
   $price = mysqli_real_escape_string($conn, trim($_POST['price']));
   $productID = mysqli_real_escape_string($conn, trim($_POST['productID']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($sizeName)) {
      array_push($errors, "Name is required");
   }
   if (empty($price)) {
      array_push($errors, "Price is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `sizes` 
      (`size`, `price`, `product_id`, `created_at`) VALUES
      ('$sizeName', '$price', '$productID', '$date')";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }

      if ($results) {
         header('location: update.products?productID='.$productID);
         exit();
      }
   }
}
