<?php
ob_start();

$query = "SELECT customers.id, customers.first_name, customers.last_name, customers.email, customers.password, customers.address, customers.status, customers.created_at, customers.updated_at FROM `customers` JOIN restaurants on customers.restaurant_id = restaurants.id WHERE restaurant_id = " . $_SESSION['id'];

$results = mysqli_query($conn, $query);
