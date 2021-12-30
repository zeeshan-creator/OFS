<?php
ob_start();

$query = "SELECT customers.id, customers.full_name, customers.email, customers.password, customers.address, customers.status, customers.created_at, customers.updated_at FROM `customers` JOIN restaurants on customers.restaurant_id = restaurants.id WHERE restaurant_id = " . $_SESSION['id'];

$customers = mysqli_query($conn, $query);
