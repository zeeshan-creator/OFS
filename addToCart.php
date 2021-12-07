<?php
ob_start();
session_start();
require('./config/db.php');

$status = "";
if (isset($_POST['productID']) && $_POST['productID'] != "") {
   $id = trim($_POST['productID']);
   $result = mysqli_query($conn, "SELECT * FROM `products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);
   // $id = $row['id'];
   $name = $row['name'];
   $price = $row['price'];
   $size = $row['size'];
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
      $status = "Product is added to your cart";
      echo 1;
   } else {
      $array_keys = array_keys($_SESSION["shopping_cart"]);
      if (in_array($id, $array_keys)) {
         foreach ($_SESSION["shopping_cart"] as &$value) {
            if ($value['id'] == $id) {
               $value['quantity'] = $value['quantity'] + 1;
               break; // Stop the loop after we've found the product
            }
         }
         $status = "Product is already added to your cart";
         echo 0;
      } else {
         foreach ($_SESSION["shopping_cart"] as &$value) {
            if ($value['id'] == $id) {
               exit; // Stop the loop after we've found the product
            }
         }
         $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
         $status = "Product is added to your cart";
         echo 1;
      }
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
      $status = "Deal is added to your cart";
      echo 1;
   } else {
      $array_keys = array_keys($_SESSION["shopping_cart"]);
      if (in_array($id, $array_keys)) {
         foreach ($_SESSION["shopping_cart"] as &$value) {
            if ($value['id'] == $id) {
               $value['quantity'] = $value['quantity'] + 1;
               break; // Stop the loop after we've found the Deal
            }
         }
         $status = "Deal is already added to your cart";
         echo 0;
      } else {
         foreach ($_SESSION["shopping_cart"] as &$value) {
            if ($value['id'] == $id) {
               exit; // Stop the loop after we've found the Deal
            }
         }
         $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
         $status = "Deal is added to your cart";
         echo 1;
      }
   }
}
