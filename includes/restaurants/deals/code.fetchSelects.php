<?php
$deal_id = $_GET['dealID'];
$restaurant_id = $_SESSION['id'];

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `deal_selects` WHERE `restaurant_id` = '$restaurant_id' AND `deal_id` ='$deal_id'";
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id = " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT * FROM `deal_selects` WHERE `restaurant_id` = '$restaurant_id' AND `deal_id` ='$deal_id'";
}

$deal_selects = mysqli_query($conn, $query);
