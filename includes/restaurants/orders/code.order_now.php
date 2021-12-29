<?php

ob_start();
session_start();

require('config/db.php');

if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo '<script>window.location.href = "index";</script>';
}
if (isset($_GET['id'])) {
   $id = trim($_GET['id']);
   $query = "SELECT * FROM restaurants WHERE id = $id";
   $results = mysqli_query($conn, $query);
   $rowNum = mysqli_num_rows($results);
   if ($rowNum > 0) {
      $row = mysqli_fetch_assoc($results);

      $query = "SELECT * FROM `categories` WHERE `restaurant_id` = $id";
      $categories = mysqli_query($conn, $query);
   } else {
      echo '<script>window.location.href = "order_now?id="' . $id . ';</script>';
   }
}

// unset($_SESSION["shopping_cart"]);
if (isset($_POST['action']) && $_POST['action'] == "remove") {
   if (!empty($_SESSION["order_cart"])) {
      foreach ($_SESSION["order_cart"] as $id => $value) {
         if ($_POST["key"] == $id) {
            unset($_SESSION["order_cart"][$id]);
            echo "<script>window.location.href = 'order_now';</script>";
         }
         if (empty($_SESSION["order_cart"])) {
            unset($_SESSION["order_cart"]);
            echo "<script>window.location.href = 'order_now';</script>";
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
