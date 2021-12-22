<?php
// SIzes
if (
   $_SESSION['role'] == 'main_branch'
) {
   $query = "SELECT * FROM `addons_products` WHERE restaurant_id = " . $_SESSION['id'] . " AND active_status = 'active'";
}

if ($_SESSION['role'] == 'admin') {
   $query = "SELECT * FROM `addons_products` WHERE restaurant_id = " . $_GET['branchId'] . " AND active_status = 'active'";
}
$addons = mysqli_query($conn, $query);
