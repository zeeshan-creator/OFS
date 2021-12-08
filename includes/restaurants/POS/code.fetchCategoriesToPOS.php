<?php

// Categories
if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT categories.id, categories.category_name, categories.category_desc, categories.created_at, restaurants.name AS mainBranchName FROM `categories` JOIN restaurants on categories.restaurant_id = restaurants.id WHERE restaurants.id = " . $_SESSION['id'] . " AND categories.active_status = 'active'";
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   $query = "SELECT categories.id, categories.category_name, categories.category_desc, categories.created_at, restaurants.name AS mainBranchName FROM `categories` JOIN restaurants on categories.restaurant_id = restaurants.id WHERE restaurants.id = " . $row['main_branch'] . " AND categories.active_status = 'active'";
}

$categories = mysqli_query($conn, $query);
