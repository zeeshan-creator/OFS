<?php

ob_start();
session_start();
require('config/db.php');

// initializing variables
$customerName;
$customerPhone;
$customerEmail;
$customerArea;
$customerAddress;
$customerNearestPlace;
$total_price;
$orderNote;

$customer_id;
$restaurant_id;
$branch_id = 0;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $customer_id = mysqli_real_escape_string($conn, trim($_POST['customer_id']));
   $customerName = mysqli_real_escape_string($conn, trim($_POST['customerName']));
   $customerPhone = mysqli_real_escape_string($conn, trim($_POST['customerPhone']));
   $customerEmail = mysqli_real_escape_string($conn, trim($_POST['customerEmail']));
   $customerArea = mysqli_real_escape_string($conn, trim($_POST['customerArea']));
   $customerAddress = mysqli_real_escape_string($conn, trim($_POST['customerAdress']));
   $customerNearestPlace = mysqli_real_escape_string($conn, trim($_POST['customerNearestPlace']));
   $total_price = mysqli_real_escape_string($conn, trim($_POST['total_price']));
   $orderNote = mysqli_real_escape_string($conn, trim($_POST['orderNote']));

   $restaurant_id = trim($_GET['id']);

   $date = date('Y-m-d');
   $time = date('H:i:s');
   $query = "INSERT INTO `orders`
         (`order_type`,
         `customer_id`,
         `customer_name`,
         `customer_phone`,
         `customer_email`,
         `area`,
         `address`,
         `nearest_place`,
         `order_note`,
         `order_date`,
         `order_time`,
         `restaurant_id`,
         `branch_id`,
         `total_price`,
         `current_status`) VALUES
         ('delivery', 
         '$customer_id',
         '$customerName',
         '$customerPhone',
         '$customerEmail',
         '$customerArea',
         '$customerAddress',
         '$customerNearestPlace',
         '$orderNote',
         '$date',
         '$time',
         '$restaurant_id',
         '$branch_id',
         '$total_price',
         'pending')";

   $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

   if ($results) {
      $query = 'SELECT LAST_INSERT_ID()';
      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($results);

      foreach ($_SESSION["order_cart"] as $product) {
         $product_id = $product['id'];
         $order_id = $row['LAST_INSERT_ID()'];
         $type = $product['type'];
         $product['type'] == 'product';
         $qty = $product['quantity'];
         $query = "INSERT INTO `order_products`(
                     `product_id`,
                     `order_id`,
                     `type`,
                     `qty`) 
                     values(
                     '$product_id',
                     '$order_id',
                     '$type',
                     '$qty')";
         $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
         if ($results) {
            unset($_SESSION["order_cart"]);
            header("Location: order_now?id=" . $restaurant_id);
            // echo '<script>window.location.href = "order_now?id="' . $restaurant_id . ';</script>';
         }
      }
   }
}
