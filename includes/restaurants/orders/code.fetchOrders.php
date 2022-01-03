<?php
ob_start();
$query;

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `orders` WHERE `restaurant_id` =" . $_SESSION['id'] . " ORDER BY `id` DESC";
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `orders` WHERE `branch_id` =" . $_SESSION['id'] . " ORDER BY `id` DESC";
}

$orders = mysqli_query($conn, $query);
