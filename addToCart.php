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
      ($id . "_" . $size) => array(
         'name' => $name,
         'id' => ($id . "_" . $size),
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
         if ($value['id'] == $id) {
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
   $image = $row['photo'];

   $cartArray = array(
      ($id . '_' . $name) => array(
         'name' => $name,
         'id' => ($id . '_' . $name),
         'price' => $price,
         'quantity' => 1,
         'type' => 'deal',
         'image' => $image
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

if (isset($_POST['addonID']) && $_POST['addonID'] != "") {
   $id = $_POST['addonID'];

   $result = mysqli_query($conn, "SELECT * FROM `addons_products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['name'];
   $price = $row['price'];
   $image = $row['photo'];

   $cartArray = array(
      ($id . '_' . $name) => array(
         'name' => $name,
         'id' => ($id . '_' . $name),
         'price' => $price,
         'quantity' => 1,
         'type' => 'addon',
         'image' => $image
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
