<?php
ob_start();

// initializing variables
$branchId;
if (isset($_GET['branchId'])) {
   $branchId = trim($_GET['branchId']);
   if ($_SESSION['role'] != 'admin') {
      header("location: restaurantDetails?id=$branchId");
      exit();
   }
} else {
   $branchId = $_SESSION['id'];
}

$restaurantID = $branchId;
$dealName;
$dealPrice;
$dealDesc;
$errors   = array();
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
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $dealName = mysqli_real_escape_string($conn, trim($_POST['dealName']));
   $dealPrice = mysqli_real_escape_string($conn, trim($_POST['dealPrice']));
   $dealDesc = mysqli_real_escape_string($conn, trim($_POST['dealDesc']));
   $target_dir = "includes/restaurants/deals/deals_imgs/";
   $randomString  = generateRandomString();
   $target_file = $target_dir . $randomString;

   // if (!empty($dealName)) {
   //    // first check the database to make sure 
   //    // a deal does not already exist with the same email 
   //    $deal_check_query = "SELECT deal_name FROM deals WHERE deal_name='$dealName' LIMIT 1";
   //    $result = mysqli_query($conn, $deal_check_query);
   //    $deal = mysqli_fetch_assoc($result);

   //    if ($deal) { // if deal exists
   //       if ($deal['name'] == $dealName) {
   //          array_push($errors, "deal name already exists try something else");
   //       }
   //    }
   // }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($dealName)) {
      array_push($errors, "Name is required");
   }

   if (empty($dealPrice)) {
      array_push(
         $errors,
         "price is required"
      );
   }

   if (empty($dealDesc)) {
      array_push($errors, "description is required");
   }

   $check = getimagesize($_FILES["photo"]["tmp_name"]);
   if ($check == false) {
      array_push($errors, "File is not an image");
   }

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
      $query = "INSERT INTO `deals` 
      (`deal_name`, `photo`, `deal_price`, `deal_desc`, `active_status`, `created_at`, `restaurant_id`) VALUES
      ('$dealName', '$filename', '$dealPrice', '$dealDesc', 'active', '$date','$restaurantID')";


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
         header('location: deals');
         exit();
      }
   }
}
