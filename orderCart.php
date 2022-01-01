<?php
session_start();
require('./config/db.php');


// unset($_SESSION["order_cart"]);
if (isset($_POST['action']) && $_POST['action'] == "remove") {
   if (!empty($_SESSION["order_cart"])) {
      foreach ($_SESSION["order_cart"] as $id => $value) {
         if ($_POST["key"] == $id) {
            unset($_SESSION["order_cart"][$id]);
         }
         if (empty($_SESSION["order_cart"])) {
            unset($_SESSION["order_cart"]);
         }
      }
   }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
   foreach ($_SESSION["order_cart"] as &$value) {
      if ($value['id'] === $_POST["id"]) {
         $value['quantity'] = $_POST['quantity'];
         break; // Stop the loop after we've found the product
      }
   }
}

if (isset($_POST['productId']) && $_POST['productId'] != "") {
   $id = trim($_POST['productId']);

   $result = mysqli_query($conn, "SELECT * FROM `products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['name'];
   $price = $row['price'];

   $cartArray = array(
      ($id . "_" . $name) => array(
         'name' => $name,
         'id' => ($id . "_" . $name),
         'price' => $price,
         'quantity' => 1,
         'type' => 'product',
      )
   );

   if (empty($_SESSION["order_cart"])) {
      $_SESSION["order_cart"] = $cartArray;
   } else {
      foreach ($_SESSION["order_cart"] as &$value) {
         if ($value['id'] == $id) {
            echo 0;
            exit; // Stop the loop after we've found the product
         }
      }
      $_SESSION["order_cart"] = array_merge($_SESSION["order_cart"], $cartArray);
   }
}

if (isset($_POST['dealID']) && $_POST['dealID'] != "") {
   $id = $_POST['dealID'];

   $result = mysqli_query($conn, "SELECT * FROM `deals` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['deal_name'];
   $price = $row['deal_price'];

   $cartArray = array(
      ($id . '_' . $name) => array(
         'name' => $name,
         'id' => ($id . '_' . $name),
         'price' => $price,
         'quantity' => 1,
         'type' => 'deal',
      )
   );

   if (empty($_SESSION["order_cart"])) {
      $_SESSION["order_cart"] = $cartArray;
   } else {
      foreach ($_SESSION["order_cart"] as &$value) {
         if ($value['id'] == $id) {
            exit; // Stop the loop after we've found the Deal
         }
      }
      $_SESSION["order_cart"] = array_merge($_SESSION["order_cart"], $cartArray);
   }
}

if (isset($_POST['addonID']) && $_POST['addonID'] != "") {
   $id = $_POST['addonID'];

   $result = mysqli_query($conn, "SELECT * FROM `addons_products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);

   $name = $row['name'];
   $price = $row['price'];

   $cartArray = array(
      ($id . '_' . $name) => array(
         'name' => $name,
         'id' => ($id . '_' . $name),
         'price' => $price,
         'quantity' => 1,
         'type' => 'addon',
      )
   );

   if (empty($_SESSION["order_cart"])) {
      $_SESSION["order_cart"] = $cartArray;
   } else {
      foreach ($_SESSION["order_cart"] as &$value) {
         if ($value['id'] == $id) {
            exit; // Stop the loop after we've found the Deal
         }
      }
      $_SESSION["order_cart"] = array_merge($_SESSION["order_cart"], $cartArray);
   }
}
