<?php
$query = "SELECT products.id, products.name, deal_select_products.deal_select_id FROM `deal_select_products` JOIN products on products.id = deal_select_products.product_id;";

$selectProducts = mysqli_query($conn, $query);
