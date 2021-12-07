<?php

// initializing variables
$orderType;
$customerName;
$customerPhone;
$orderNote;
$customerEmail;
$total_price;
$branch_id;
$accepted_by = $_SESSION['id'];
$acceptors_role = $_SESSION['role'];

if (isset($_POST['action']) && $_POST['action'] == "saveOrder") {
   // receive all input values from the form
   $orderType = mysqli_real_escape_string($conn, trim($_POST['orderType']));
   $total_price = mysqli_real_escape_string($conn, trim($_POST['total_price']));
   $customerName = mysqli_real_escape_string($conn, trim($_POST['customerName']));
   $customerPhone = mysqli_real_escape_string($conn, trim($_POST['customerPhone']));
   $orderNote = mysqli_real_escape_string($conn, trim($_POST['orderNote']));
   $customerEmail = mysqli_real_escape_string($conn, trim($_POST['customerEmail']));

   if ($_SESSION['role'] == 'main_branch') {
      $restaurant_id = $_SESSION['id'];
      $branch_id = null;
   }
   if ($_SESSION['role'] == 'sub_branch') {
      $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
      $results = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($results);
      $restaurant_id = $row['main_branch'];
      $branch_id = $_SESSION['id'];
   }

   $date = date('Y-m-d');
   $time = date('H:i:s');
   $query = "INSERT INTO `orders`
         (`order_type`,
         `customer_name`,
         `customer_phone`,
         `customer_email`,
         `order_note`,
         `order_date`,
         `order_time`,
         `restaurant_id`,
         `branch_id`,
         `total_price`,
         `current_status`) VALUES
         ('$orderType', 
         '$customerName',
         '$customerPhone',
         '$customerEmail',
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

      foreach ($_SESSION["shopping_cart"] as $product) {
         $product_id = $product['id'];
         $order_id = $row['LAST_INSERT_ID()'];
         $type = $product['type'];
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
            unset($_SESSION["shopping_cart"]);
         }
      }
   }
}
