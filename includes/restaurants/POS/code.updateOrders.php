<?php

$_SESSION['order_products'] = array();
$query;
$subtotal = 0;
$deliverycharges = 150;
$total = 0;

if (!isset($_GET['orderID'])) {
   echo '<script>window.location.href = "orders";</script>';
   exit();
}

if (isset($_GET['orderID'])) {
   $orderID = trim($_GET['orderID']);

   $order_products_query = "SELECT `id`,`product_id`, `type`, `qty`, `size` FROM `order_products` WHERE `order_id` = $orderID";
   $order_products_result = mysqli_query($conn, $order_products_query);

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
   $order_id = trim($_POST['order_id']);
   $query  = 'DELETE FROM `order_products` WHERE `id` =' . $id;
   $result = mysqli_query($conn, $query);
   if ($result) {
      echo '<script>window.location.href = "orderDetails?orderID=' . $order_id . '";</script>';
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
      echo '<script>window.location.href = "orderDetails?orderID=' . $order_id . '";</script>';
   }
}

ob_end_flush();
