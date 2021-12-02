<?php
ob_start();
session_start();
require('./config/db.php');

$status = "";
if (isset($_POST['productID']) && $_POST['productID'] != "") {
   $id = $_POST['productID'];
   $result = mysqli_query($conn, "SELECT * FROM `products` WHERE `id`='$id'");
   $row = mysqli_fetch_assoc($result);
   // $id = $row['id'];
   $name = $row['name'];
   $price = $row['price'];
   $image = $row['photo'];

   $cartArray = array(
      $name => array(
         'name' => $name,
         'id' => $id,
         'price' => $price,
         'quantity' => 1,
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
