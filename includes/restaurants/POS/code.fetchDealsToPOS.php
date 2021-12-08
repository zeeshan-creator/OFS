<?php

// Deals
if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT `id`, `deal_name`, `deal_desc`, `deal_price`, `active_status` FROM `deals` WHERE restaurant_id = " . $_SESSION['id'] . " AND active_status = 'active'";
}
if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT `id`, `deal_name`, `deal_desc`, `deal_price`, `active_status` FROM `deals` WHERE restaurant_id = " . $row['main_branch'] . " AND active_status = 'active'";
}

$deals = mysqli_query($conn, $query);
