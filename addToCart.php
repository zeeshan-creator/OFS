<?php
ob_start();
session_start();
require('./config/db.php');

if (isset($_POST['productID']) && $_POST['productID'] != "") {
   $id = trim($_POST['productID']);
   $product_size = trim($_POST['product_size']);

   $result = mysqli_query($conn, "SELECT * FROM `products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['name'];
   $price = $row['price'];
   $size = $product_size;
   $image = $row['photo'];

   $cartArray = array(
      $name => array(
         'name' => $name,
         'id' => $id,
         'price' => $price,
         'quantity' => 1,
         'type' => 'product',
         'size' => $size,
         'image' => $image
      )
   );

   if (empty($_SESSION["shopping_cart"])) {
      $_SESSION["shopping_cart"] = $cartArray;
      echo 1;
   } else {
      foreach ($_SESSION["shopping_cart"] as &$value) {
         if ($value['id'] == $id && $value['size'] == $size) {
            echo 0;
            exit; // Stop the loop after we've found the product
         }
      }
      $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
      echo 1;
   }
}

if (isset($_POST['dealID']) && $_POST['dealID'] != "") {
   $id = $_POST['dealID'];

   $result = mysqli_query($conn, "SELECT * FROM `deals` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['deal_name'];
   $price = $row['deal_price'];

   $cartArray = array(
      $name => array(
         'name' => $name,
         'id' => $id,
         'price' => $price,
         'quantity' => 1,
         'type' => 'deal',
      )
   );

   if (empty($_SESSION["shopping_cart"])) {
      $_SESSION["shopping_cart"] = $cartArray;
      echo 1;
   } else {
      foreach ($_SESSION["shopping_cart"] as &$value) {
         if ($value['id'] == $id) {
            exit; // Stop the loop after we've found the Deal
         }
      }
      $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
      echo 1;
   }
}
