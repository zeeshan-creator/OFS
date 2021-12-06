<?php

// initializing variables
$orderType;
$customerName;
$customerPhone;
$orderNote;
$customerEmail;
$accepted_by = $_SESSION['id'];
$acceptors_role = $_SESSION['role'];

if (isset($_POST['action']) && $_POST['action'] == "saveOrder") {
   // receive all input values from the form
   $orderType = mysqli_real_escape_string($conn, trim($_POST['orderType']));
   $customerName = mysqli_real_escape_string($conn, trim($_POST['customerName']));
   $customerPhone = mysqli_real_escape_string($conn, trim($_POST['customerPhone']));
   $orderNote = mysqli_real_escape_string($conn, trim($_POST['orderNote']));
   $customerEmail = mysqli_real_escape_string($conn, trim($_POST['customerEmail']));

   $date = date('Y-m-d H:i:s');
   $query = "INSERT INTO `orders`
         (`orderType`,
         `customerName`,
         `customerPhone`,
         `customerEmail`,
         `order_note`,
         `accepted_by`,
         `acceptors_role`,
         `accepted_at`) VALUES
         ('$orderType', 
         '$customerName',
         '$customerPhone',
         '$customerEmail',
         '$orderNote',
         '$accepted_by',
         '$acceptors_role',
         '$date')";


   $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

   if ($results) {
      $query = 'SELECT LAST_INSERT_ID()';
      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($results);

      foreach ($_SESSION["shopping_cart"] as $product) {
         $query = "INSERT INTO `order_products`(`product_id`, `order_id`) 
         values(" . $product['id'] . "," . $row['LAST_INSERT_ID()'] . ")";
         $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
         if ($results) {
            unset($_SESSION["shopping_cart"]);
         }
      }
   }
}
