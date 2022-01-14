<?php


// 
if (isset($_GET['productID'])) {
   $id = trim($_GET['productID']);
   $query = "SELECT * FROM `sizes` WHERE product_id = " . $id;
   $sizes = mysqli_query($conn, $query);
}
