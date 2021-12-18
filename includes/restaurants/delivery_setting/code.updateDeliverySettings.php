<?php

// initializing variables
$restaurantId;
$min_delivery;
$min_pickup;
$min_dineIn;
$packaging_charges;
$delivery_charges;
$free_delivery_over;
$tax;
$delivery_time;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $restaurantId = mysqli_real_escape_string($conn, trim($_POST['restaurantId']));
   $min_delivery = mysqli_real_escape_string($conn, trim($_POST['min_delivery']));
   $min_pickup = mysqli_real_escape_string($conn, trim($_POST['min_pickup']));
   $min_dineIn = mysqli_real_escape_string($conn, trim($_POST['min_dineIn']));
   $packaging_charges = mysqli_real_escape_string($conn, trim($_POST['packaging_charges']));
   $delivery_charges = mysqli_real_escape_string($conn, trim($_POST['delivery_charges']));
   $free_delivery_over = mysqli_real_escape_string($conn, trim($_POST['free_delivery_over']));
   $tax = mysqli_real_escape_string($conn, trim($_POST['tax']));
   $delivery_time = mysqli_real_escape_string($conn, trim($_POST['delivery_time']));

   $query = "UPDATE `delivery_settings` SET 
            `min_delivery` = '$min_delivery',
            `min_pickup` = '$min_pickup',
            `min_dineIn` = '$min_dineIn',
            `packaging_charges` = '$packaging_charges',
            `delivery_charges` = '$delivery_charges',
            `free_delivery_over` = '$free_delivery_over',
            `tax` = '$tax',
            `delivery_time` = '$delivery_time'
            WHERE `restaurant_id` = '$restaurantId'";

   $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

   if ($results) {
      echo '<script>window.location.href = "delivery_setting";</script>';
      exit();
   }
}
