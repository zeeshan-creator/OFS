<?php
// SIzes
if (
   $_SESSION['role'] == 'main_branch'
) {
   $query = "SELECT * FROM `sizes` WHERE restaurant_id = " . $_SESSION['id'] . " AND active_status = 'active'";
}

if ($_SESSION['role'] == 'admin') {
   $query = "SELECT * FROM `sizes` WHERE restaurant_id = " . $_GET['branchId'] . " AND active_status = 'active'";
}
$sizes = mysqli_query($conn, $query);
