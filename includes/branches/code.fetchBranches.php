<?php
ob_start();

require('config/db.php');

$query = "SELECT * FROM branches";
$results = mysqli_query($conn, $query);
