<?php
ob_start();

require('config/db.php');

$query = "SELECT * FROM restaurants";
$results = mysqli_query($conn, $query);
