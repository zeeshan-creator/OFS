<?php
ob_start();

require('config/db.php');

$query = "SELECT sub_restaurants.id,sub_restaurants.name AS subBranchName, sub_restaurants.email, sub_restaurants.password,sub_restaurants.phone,sub_restaurants.role, restaurants.name AS mainBranchName FROM `sub_restaurants` JOIN restaurants on sub_restaurants.main_branch = restaurants.id";
$results = mysqli_query($conn, $query);
