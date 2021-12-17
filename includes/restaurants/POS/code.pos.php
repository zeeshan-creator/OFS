<?php
// Initializing varibles
$query;
$subtotal = 0;
$deliverycharges = 150;
$offerDiscount = null;
$offerPercentage = null;
$ordersOver = null;
$total = 0;

$query = "SELECT 
          `id`,
          `offer_name`,
          `offer_percentage`,
          `offer_message`,
          `order_over`,
          `valid_from`,
          `valid_till`
          FROM `offers` WHERE
          `restaurant_id` = " . $_SESSION['id'] . " AND `active_status` = 'active'  LIMIT 1 ";

$offer_results = mysqli_query($conn, $query) or die(mysqli_error($conn));
$offer = mysqli_fetch_assoc($offer_results);

if ($offer) {
   // Offer Date Calculation
   $current_date = date_create(Date('Y-m-d')); // current 
   $valid_from = date_create($offer['valid_from']); // valid from
   $valid_till = date_create($offer['valid_till']); // valid till
   $start = date_diff($valid_from, $current_date);

   if ($start->format("%R%a") >= 0) {
      $end = date_diff($valid_till, $current_date);
      if ($end->format("%R%a") > 0) {
         $offerPercentage = null;
      } else {
         $offerPercentage = $offer['offer_percentage'];
         $ordersOver = $offer['order_over'];
      }
   }
}

// unset($_SESSION["shopping_cart"]);
if (isset($_POST['action']) && $_POST['action'] == "remove") {
   if (!empty($_SESSION["shopping_cart"])) {
      foreach ($_SESSION["shopping_cart"] as $id => $value) {
         if ($_POST["key"] == $id) {
            unset($_SESSION["shopping_cart"][$id]);
            echo "<script>window.location.href = 'POS';</script>";
         }
         if (empty($_SESSION["shopping_cart"])) {
            unset($_SESSION["shopping_cart"]);
            echo "<script>window.location.href = 'POS';</script>";
         }
      }
   }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
   foreach ($_SESSION["shopping_cart"] as &$value) {
      if ($value['id'] === $_POST["id"]) {
         $value['quantity'] = $_POST["quantity"];
         if (isset($_POST['product_size'])) {
            $value['size'] = $_POST["product_size"];
         }
         break; // Stop the loop after we've found the product
      }
   }
}
