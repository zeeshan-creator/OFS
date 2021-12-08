<?php
ob_start();

$query = "SELECT categories.id, categories.category_name, categories.category_desc, categories.active_status, categories.created_at, restaurants.name AS mainBranchName FROM `categories` JOIN restaurants on categories.restaurant_id = restaurants.id WHERE restaurants.id = " . $_SESSION['id'];

$categories = mysqli_query($conn, $query);
