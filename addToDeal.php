<?php
ob_start();
session_start();
require('./config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $productID = trim($_POST['productID']);
   $dealID = trim($_POST['dealID']);

   $query = "SELECT `product_id` FROM `deal_products` WHERE `deal_id`= '$dealID' AND `product_id`= '$productID'";
   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
   $totalrows = mysqli_num_rows($result);

   if ($totalrows > 0) {
      echo 0;
      exit;
   } else {
      $query = "INSERT INTO `deal_products` (`deal_id`, `product_id`, `qty`) VALUES ('$dealID', '$productID', 1)";
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if ($result) {
         echo 1;
         exit;
      }
   }
}

// echo 0;
// exit;
