<?php

// SIzes
if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `addons_products` WHERE restaurant_id = " . $_SESSION['id'] . " AND active_status = 'active'";
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT * FROM `addons_products` WHERE restaurant_id = " . $row['main_branch'] . " AND active_status = 'active'";
}
$addons = mysqli_query($conn, $query);
