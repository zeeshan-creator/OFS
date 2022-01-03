<?php
ob_start();
$query;

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `orders` WHERE `restaurant_id` =" . $_SESSION['id'];
}

if ($_SESSION['role'] == 'sub_branch') {
   // $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
   // $results = mysqli_query($conn, $query);
   // $row = mysqli_fetch_assoc($results);

   $query = "SELECT * FROM `orders` WHERE `branch_id` =" . $_SESSION['id'];
}

$orders = mysqli_query($conn, $query);
