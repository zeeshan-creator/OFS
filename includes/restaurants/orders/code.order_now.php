<?php

ob_start();
session_start();
require('config/db.php');

if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo '<script>window.location.href = "index";</script>';
}

// unset($_SESSION["order_cart"]);
if (isset($_POST['action']) && $_POST['action'] == "remove") {
   if (!empty($_SESSION["order_cart"])) {
      foreach ($_SESSION["order_cart"] as $id => $value) {
         if ($_POST["key"] == $id) {
            echo "<script>window.location.href = 'order_now?id='" . $id . ";</script>";
            unset($_SESSION["order_cart"][$id]);
         }
         if (empty($_SESSION["order_cart"])) {
            echo "<script>window.location.href = 'order_now?id='" . $id . ";</script>";
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
