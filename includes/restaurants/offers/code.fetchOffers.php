<?php
ob_start();
$query;

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT  `offers`.`id`, `offer_name`, `offer_percentage`, `offer_message`, `order_over`, `valid_from`, `valid_till`, `offers`.`active_status` FROM `offers` JOIN restaurants on offers.restaurant_id = restaurants.id WHERE restaurants.id = " . $_SESSION['id'];
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id = " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT  `offers`.`id`, `offer_name`, `offer_percentage`, `offer_message`, `order_over`, `valid_from`, `valid_till`, `offers`.`active_status` FROM `offers` JOIN restaurants on offers.restaurant_id = restaurants.id WHERE restaurants.id = " . $row['main_branch'];
}

$results = mysqli_query($conn, $query);
