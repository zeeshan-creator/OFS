<?php
ob_start();
session_start();
require('./config/db.php');

if (isset($_POST['action']) && $_POST['action'] == "addToSelect") {

   $dealID = trim($_POST['dealID']);
   $Restaurant_id = trim($_POST['Restaurant_id']);

   $query = "INSERT INTO `deal_selects`(`deal_id`, `restaurant_id`) VALUES ('$dealID', '$Restaurant_id')";
   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
   $totalrows = mysqli_num_rows($result);

   if ($totalrows > 0) {
      echo 0;
      exit;
   } else {
      echo 1;
      exit;
   }
}

if (isset($_POST['action']) && $_POST['action'] == "addToSelectProduct") {

   $productID = trim($_POST['productID']);
   $selectID = trim($_POST['selectID']);

   $query = "INSERT INTO `deal_select_products`(
      `deal_select_id`,
      `product_id`) 
      VALUES (
      '$selectID',
      '$productID')";
   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
   $totalrows = mysqli_num_rows($result);

   if ($totalrows > 0) {
      echo 0;
      exit;
   } else {
      echo 1;
      exit;
   }
}

// echo 0;
// exit;
