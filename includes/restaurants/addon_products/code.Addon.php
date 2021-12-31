<?php
ob_start();

// initializing variables
$sizeName;
$restaurant_id;
$imageFileType;
$randomString;
function generateRandomString($length = 10)
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
}

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
   $target_dir = "includes/restaurants/addon_products/addons_imgs/";
   $randomString  = generateRandomString();
   $target_file = $target_dir . $randomString;

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
   $imageFileType = strtolower(pathinfo(basename($_FILES["photo"]["name"]), PATHINFO_EXTENSION));
   if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
   }

   if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file . "." . $imageFileType)) {
      array_push($errors, "Sorry, there was an error uploading your file");
   } else {
      $filename = $randomString . "." . $imageFileType;
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `addons_products` 
      (`name`, `restaurant_id`, `price`, `photo`, `description`, `active_status`, `created_at`) VALUES
      ('$name', '$restaurant_id', '$price', '$filename', '$description', 'active', '$date')";

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
