<?php
if ($_SESSION['role'] == 'admin') {
   $branchID = trim($_GET['branchId']);

   $query = "SELECT * FROM `deal_selects` WHERE `restaurant_id` = " . $branchID;
}

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `deal_selects` WHERE `restaurant_id` = " . $_SESSION['id'];
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT * FROM `deal_selects` WHERE `restaurant_id` = " . $row['main_branch'];
}

$deal_selects = mysqli_query($conn, $query);
