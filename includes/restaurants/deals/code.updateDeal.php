<?php
ob_start();

// initializing variables
$dealID;
$dealName;
$dealPrice;
$dealDesc;
$photo;
$oldImage;
$active_status;
$errors   = array();

if (isset($_POST['action']) && $_POST['action'] == "update") {
   // receive all input values from the form
   $dealID = mysqli_real_escape_string($conn, trim($_POST['dealID']));
   $dealName = mysqli_real_escape_string($conn, trim($_POST['dealName']));
   $dealPrice = mysqli_real_escape_string($conn, trim($_POST['dealPrice']));
   $dealDesc = mysqli_real_escape_string($conn, trim($_POST['dealDesc']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $oldImage = mysqli_real_escape_string($conn, trim($_POST['oldImage']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (
      basename($_FILES["newImage"]["name"]) != '' && basename($_FILES["newImage"]["name"]) != null
   ) {
      $target_dir = "includes/restaurants/deals/deals_imgs/";

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

   if (empty($dealName)) {
      array_push($errors, "Name is required");
   }

   if (empty($dealPrice)) {
      array_push($errors, "price is required");
   }

   if (empty($dealDesc)) {
      array_push($errors, "description is required");
   }

   if (empty($active_status)) {
      array_push(
         $errors,
         "active_status is required"
      );
   }

   // Finally, update if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `deals` SET 
         `deal_name` = '$dealName', 
         `photo` = '$photo',
         `deal_price` = '$dealPrice',
         `deal_desc` = '$dealDesc',
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `deals`.`id` = $dealID";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         echo '<script>window.location.href = "deals";</script>';
         exit();
      }
   }
}

if (!isset($_GET['dealID'])) {
   echo '<script>window.location.href = "deals";</script>';
   exit();
}

$_SESSION['deal_products'] = array();

if (isset($_POST['action']) && $_POST['action'] == "remove") {
   $product_id = trim($_POST['id']);
   $products_query  = 'DELETE FROM `deal_products` WHERE `product_id` =' . $product_id;
   mysqli_query($conn, $products_query);
}



if (isset($_GET['dealID'])) {
   $dealID = trim($_GET['dealID']);

   $deal_query = "SELECT * FROM deals WHERE id='$dealID' LIMIT 1";
   $result = mysqli_query($conn, $deal_query);
   $row = mysqli_fetch_assoc($result);

   if ($row) {
      // Retrieve individual field value
      $name = $row["deal_name"];
      $price = $row["deal_price"];
      $description = $row["deal_desc"];
      $photo = $row["photo"];
      $active_status = $row["active_status"];
   } else {
      echo '<script>window.location.href = "deals";</script>';
      exit();
   }
}

ob_end_flush();
