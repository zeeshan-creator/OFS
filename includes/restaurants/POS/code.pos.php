<?php

// unset($_SESSION["shopping_cart"]);
if (isset($_POST['action']) && $_POST['action'] == "remove") {
   if (!empty($_SESSION["shopping_cart"])) {
      foreach ($_SESSION["shopping_cart"] as $id => $value) {
         if ($_POST["key"] == $id) {
            unset($_SESSION["shopping_cart"][$id]);
         }
         if (empty($_SESSION["shopping_cart"])) {
            unset($_SESSION["shopping_cart"]);
         }
      }
   }
}

if (isset($_POST['action']) && $_POST['action'] == "changeQty") {
   foreach ($_SESSION["shopping_cart"] as &$value) {
      if ($value['id'] === $_POST["id"]) {
         $value['quantity'] = $_POST["quantity"];
         break; // Stop the loop after we've found the product
      }
   }
}

if (isset($_POST['action']) && $_POST['action'] == "changeSize") {
   foreach ($_SESSION["shopping_cart"] as &$value) {
      if ($value['id'] === $_POST["id"]) {
         if (isset($_POST['product_size'])) {
            $value['size'] = $_POST["product_size"];
         }
         break; // Stop the loop after we've found the product
      }
   }
}