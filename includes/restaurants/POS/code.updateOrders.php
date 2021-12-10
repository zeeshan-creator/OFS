<?php

// initializing variables
$orderType;
$customerName;
$customerPhone;
$orderNote;
$customerEmail;
$total_price;
$restaurant_id;
$branch_id = 0;

$_SESSION['order_products'] = array();
$query;
$subtotal = 0;
$deliverycharges = 150;
$total = 0;

$id;
$order_product_id;
$type;
$size = null;

if (isset($_POST['action']) && $_POST['action'] == "updatePrice") {
   echo '<script>alert(123478)</script>';

   $order_product_id = trim($_POST['order_product_id']);
   $total_price = trim($_POST['total_price']);
   $query = "UPDATE `orders` SET `total_price` =  '$total_price' WHERE `id` = " . $id;

   mysqli_query($conn, $query) or die(mysqli_error($conn));
}

// addProductToUpdateDeal
if (isset($_POST['action']) && $_POST['action'] == "addProduct") {

   $id = trim($_POST['id']);
   $order_product_id = trim($_POST['order_product_id']);
   $type = trim($_POST['type']);
   if ($_POST['product_size']) {
      $size = trim($_POST['product_size']);
   }

   $query = "INSERT INTO `order_products`(`product_id`,`order_id`, `type`, `qty`, `size`)
             VALUES ('$id', '$order_product_id', '$type', '1', '$size') ";

   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
   if ($results) {
      echo '<script>window.location.href = "orderDetails?orderID=' . $order_product_id . '";</script>';
   }
}

if (!isset($_GET['orderID'])) {
   echo '<script>window.location.href = "orders";</script>';
   exit();
}

if (isset($_POST['action']) && $_POST['action'] == "updateOrder") {

   // receive all input values from the form
   $id = trim($_GET['orderID']);
   $orderType = mysqli_real_escape_string($conn, trim($_POST['orderType']));
   $total_price = mysqli_real_escape_string($conn, trim($_POST['total_price']));
   $customerName = mysqli_real_escape_string($conn, trim($_POST['customerName']));
   $customerPhone = mysqli_real_escape_string($conn, trim($_POST['customerPhone']));
   $customerEmail = mysqli_real_escape_string($conn, trim($_POST['customerEmail']));
   $orderNote = mysqli_real_escape_string($conn, trim($_POST['orderNote']));

   if ($_SESSION['role'] == 'main_branch') {
      $restaurant_id = $_SESSION['id'];
      $branch_id = 0;
   }

   if ($_SESSION['role'] == 'sub_branch') {
      $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
      $results = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($results);
      $restaurant_id = $row['main_branch'];
      $branch_id = $_SESSION['id'];
   }

   $date = date('Y-m-d H:i:s');
   $query = "UPDATE `orders` SET 
      `order_type`= '$orderType', 
      `customer_name`= '$customerName',
      `customer_phone`= '$customerPhone',
      `customer_email`= '$customerEmail',
      `order_note`= '$orderNote',
      `updated_at`= '$date',
      `total_price`= '$total_price'
      WHERE 
      `id` = '$id'";

   $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
   if ($results) {
      echo '<script>window.location.href = "orderDetails?orderID=' . $id . '";</script>';
   }
}

if (isset($_GET['orderID'])) {
   $orderID = trim($_GET['orderID']);

   $order_products_query = "SELECT `id`,`product_id`, `type`, `qty`, `size` 
                              FROM `order_products` WHERE `order_id` = $orderID";
   $order_products_result = mysqli_query($conn, $order_products_query);
   $order_products_num_rows = mysqli_num_rows($order_products_result);

   if ($order_products_num_rows > 0) {
      while ($rows = mysqli_fetch_assoc($order_products_result)) {

         // If type is PRODUCTS
         if ($rows['type'] == 'product') {
            $products_query  =
               'SELECT `id`, `name`, `price`, `photo` FROM `products` where `id` = ' . $rows['product_id'];
            $products_result = mysqli_query($conn, $products_query);
            $order_products = mysqli_fetch_assoc($products_result);

            $id = $rows['id'];
            $order_id = $orderID;
            $name = $order_products['name'];
            $price = $order_products['price'];
            $image = $order_products['photo'];
            $type = $rows['type'];
            $qty = $rows['qty'];
            $size = $rows['size'];

            $orderProducts = array(
               $name => array(
                  'id' => $id,
                  'order_id' => $order_id,
                  'name' => $name,
                  'price' => $price,
                  'type' => $type,
                  'quantity' => $qty,
                  'size' => $size,
                  'image' => $image
               )
            );
         }

         // If type is DEAL
         if ($rows['type'] == 'deal') {
            $products_query  =
               'SELECT `id`, `deal_name`, `deal_price` FROM `deals` where `id` = ' . $rows['product_id'];
            $products_result = mysqli_query($conn, $products_query);
            $order_products = mysqli_fetch_assoc($products_result);

            $id = $rows['id'];
            $name = $order_products['deal_name'];
            $price = $order_products['deal_price'];
            $type = $rows['type'];
            $qty = $rows['qty'];

            $orderProducts = array(
               $name => array(
                  'id' => $id,
                  'order_id' => $orderID,
                  'name' => $name,
                  'price' => $price,
                  'quantity' => $qty,
                  'type' => 'deal',
               )
            );
         }

         $_SESSION['order_products'] = array_merge($_SESSION['order_products'], $orderProducts);
      }
   }

   $restaurant_query = "SELECT * FROM orders WHERE id='$orderID' LIMIT 1";
   $result = mysqli_query($conn, $restaurant_query);
   $row = mysqli_fetch_assoc($result);

   if ($row) {
      // Retrieve individual field value
      $id = $row["id"];
      $order_type = $row["order_type"];
      $customer_name = $row["customer_name"];
      $customer_phone = $row["customer_phone"];
      $customer_email = $row["customer_email"];
      $order_note = $row["order_note"];
      $order_date = $row["order_date"];
      $order_time = $row["order_time"];
      $total_price = $row["total_price"];
      $current_status = $row["current_status"];
      $accepted_at = $row["accepted_at"];
      $pending_at = $row["pending_at"];
      $cancelled_at = $row["cancelled_at"];
      $cancellation_note = $row["cancellation_note"];
      $delivered_at = $row["delivered_at"];
   } else {
      echo '<script>window.location.href = "orders";</script>';
      exit();
   }
}

if (isset($_POST['action']) && $_POST['action'] == "remove") {
   $id = trim($_POST['id']);
   $query  = 'DELETE FROM `order_products` WHERE `id` =' . $id;
   $result = mysqli_query($conn, $query);
   if ($result) {
      echo '<script>window.location.href = "orderDetails?orderID=' . $orderID . '";</script>';
   }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
   $query;

   $id = trim($_POST['id']);
   $type = trim($_POST['type']);
   $qty = trim($_POST['quantity']);

   if (isset($_POST['type']) && $_POST['type'] == "product") {
      $size = trim($_POST['size']);
      $query  = "UPDATE `order_products` SET `qty` =  '$qty', `size` =  '$size'  WHERE `id` = " . $id;
   }

   if (isset($_POST['type']) && $_POST['type'] == "deal") {
      $query  = "UPDATE `order_products` SET `qty` =  '$qty'  WHERE `id` = " . $id;
   }

   $result = mysqli_query($conn, $query);

   if ($result) {
      echo '<script>window.location.href = "orderDetails?orderID=' . $orderID . '";</script>';
   }
}
