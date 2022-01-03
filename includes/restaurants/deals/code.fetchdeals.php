<?php
ob_start();
$query;

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT deals.id, deals.deal_name, deals.photo, deals.deal_price, deals.deal_desc, deals.active_status, deals.created_at, deals.updated_at,restaurants.id AS restaurantID, restaurants.name AS restaurantName FROM `deals` JOIN restaurants on deals.restaurant_id = restaurants.id WHERE restaurants.id = " . $_SESSION['id'];
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT `main_branch` FROM `sub_restaurants` where id = " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT deals.id, deals.deal_name, deals.photo, deals.deal_price, deals.deal_desc, deals.active_status, deals.created_at, deals.updated_at,restaurants.id AS restaurantID, restaurants.name AS restaurantName FROM `deals` JOIN restaurants on deals.restaurant_id = restaurants.id WHERE restaurants.id = " . $row['main_branch'];
}

$deals = mysqli_query($conn, $query);
