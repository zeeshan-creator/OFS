<?php
ob_start();
$query;
require('config/db.php');
if ($_SESSION['role'] == 'admin') {
   $query = "SELECT sub_restaurants.id,sub_restaurants.name AS subBranchName, sub_restaurants.email, sub_restaurants.password,sub_restaurants.phone,sub_restaurants.role, restaurants.name AS mainBranchName FROM `sub_restaurants` JOIN restaurants on sub_restaurants.main_branch = restaurants.id";
}

if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT sub_restaurants.id,sub_restaurants.name AS subBranchName, sub_restaurants.email, sub_restaurants.password,sub_restaurants.phone,sub_restaurants.role, restaurants.name AS mainBranchName, sub_restaurants.active_status FROM `sub_restaurants` JOIN restaurants on sub_restaurants.main_branch = restaurants.id WHERE restaurants.id = " . $_SESSION['id'];
}

$results = mysqli_query($conn, $query);
