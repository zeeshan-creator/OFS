<?php
ob_start();

// initializing variables
$dealID;
$dealName;
$dealPrice;
$dealDesc;
$photo;
$oldImage;
$active_status;
$errors   = array();

if (isset($_POST['action']) && $_POST['action'] == "update") {
   // receive all input values from the form
   $dealID = mysqli_real_escape_string($conn, trim($_POST['dealID']));
   $dealName = mysqli_real_escape_string($conn, trim($_POST['dealName']));
   $dealPrice = mysqli_real_escape_string($conn, trim($_POST['dealPrice']));
   $dealDesc = mysqli_real_escape_string($conn, trim($_POST['dealDesc']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $oldImage = mysqli_real_escape_string($conn, trim($_POST['oldImage']));

   // if (!empty($dealName)) {
   //    // first check the database to make sure 
   //    // a deal does not already exist with the same name 
   //    $deal_name_check_query = "SELECT id,deal_name FROM deals WHERE deal_name = '$dealName' LIMIT 1";
   //    $result = mysqli_query($conn, $deal_name_check_query);
   //    $deal = mysqli_fetch_assoc($result);

   //    if ($deal) { // if deal exists
   //       if ($deal['id'] != $dealID) {
   //          if ($deal['deal_name'] == $dealName) {
   //             array_push($errors, "deal name already exists try something else");
   //          }
   //       }
   //    }
   // }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (
      basename($_FILES["newImage"]["name"]) != '' && basename($_FILES["newImage"]["name"]) != null
   ) {
      $target_dir = "includes/restaurants/deals/deals_imgs/";

      $check = getimagesize($_FILES["newImage"]["tmp_name"]);
      if ($check == false) {
         array_push($errors, "File is not an image");
      }

      // Check file size
      if ($_FILES["newImage"]["size"] > 1000000) { // 1000KB is 1MB
         array_push($errors, "Sorry, your file is too large");
      }

      // Allow certain file formats
      $imageFileType = strtolower(pathinfo(basename($_FILES["newImage"]["name"]), PATHINFO_EXTENSION));
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
         array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed");
      }

      if (!move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_dir . ($oldImage))) {
         array_push($errors, "Sorry, there was an error uploading your file");
      }

      $photo = $oldImage;
   }

   if (
      basename($_FILES["newImage"]["name"]) == '' && basename($_FILES["newImage"]["name"]) == null
   ) {
      $photo = $oldImage;
   }

   if (empty($dealName)) {
      array_push($errors, "Name is required");
   }

   if (empty($dealPrice)) {
      array_push($errors, "price is required");
   }

   if (empty($dealDesc)) {
      array_push($errors, "description is required");
   }

   if (empty($active_status)) {
      array_push(
         $errors,
         "active_status is required"
      );
   }

   // Finally, update if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `deals` SET 
         `deal_name` = '$dealName', 
         `photo` = '$photo',
         `deal_price` = '$dealPrice',
         `deal_desc` = '$dealDesc',
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `deals`.`id` = $dealID";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         echo '<script>window.location.href = "deals";</script>';
         exit();
      }
   }
}


if (!isset($_GET['dealID'])) {
   echo '<script>window.location.href = "deals";</script>';
   exit();
}

$_SESSION['deal_products'] = array();

if (isset($_POST['action']) && $_POST['action'] == "remove") {
   $product_id = trim($_POST['id']);
   $products_query  = 'DELETE FROM `deal_products` WHERE `product_id` =' . $product_id;
   mysqli_query($conn, $products_query);
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
   $product_qty = trim($_POST['qty']);
   $product_size = isset($_POST['product_size']) ? $_POST['product_size'] : null;
   $deal_products_id = trim($_POST['deal_products_id']);
   // $products_query  = 'UPDATE `deal_products` SET `qty`= ' . $product_qty . ' WHERE `id` =' . $deal_products_id;
   $products_query  = "UPDATE `deal_products` SET `qty`= '$product_qty', `size`= '$product_size' WHERE `id` =" . $deal_products_id;
   mysqli_query($conn, $products_query);
}

if (isset($_GET['dealID'])) {
   $dealID = trim($_GET['dealID']);

   $deal_products_query = "SELECT `product_id` FROM `deal_products` WHERE `deal_id` = $dealID";
   $deal_products_result = mysqli_query($conn, $deal_products_query);

   while ($rows = mysqli_fetch_assoc($deal_products_result)) {


      $products_qty_query  = 'SELECT `id`, `qty`, `size`, `type` FROM `deal_products` where `product_id` = ' . $rows['product_id'] . ' AND `deal_id` = ' . $dealID;
      $products_qty_result = mysqli_query($conn, $products_qty_query);
      $deal_products = mysqli_fetch_assoc($products_qty_result);

      if ($deal_products['type'] == 'product') {

         $products_query  = 'SELECT `id`, `name`, `price`, `photo` FROM `products` where `id` =' . $rows['product_id'];
         $products_result = mysqli_query($conn, $products_query);
         $row = mysqli_fetch_assoc($products_result);

         $id = $row['id'];
         $name = $row['name'];
         $price = $row['price'];
         $qty = $deal_products['qty'];
         $size = $deal_products['size'];
         $type = $deal_products['type'];
         $deal_products_id = $deal_products['id'];
         $image = $row['photo'];

         $dealProducts = array(
            $name => array(
               'id' => $id,
               'name' => $name,
               'price' => $price,
               'qty' => $qty,
               'size' => $size,
               'type' => $type,
               'deal_products_id' => $deal_products_id,
               'image' => $image
            )
         );
         $_SESSION['deal_products'] = array_merge($_SESSION['deal_products'], $dealProducts);
      }

      if ($deal_products['type'] == 'addon') {

         $addons_query  = 'SELECT `id`, `name`, `price` FROM `addons_products` where `id` =' . $rows['product_id'];
         $addons_result = mysqli_query($conn, $addons_query);
         $row = mysqli_fetch_assoc($addons_result);

         $id = $row['id'];
         $name = $row['name'];
         $price = $row['price'];
         $qty = $deal_products['qty'];
         $size = $deal_products['size'];
         $type = $deal_products['type'];
         $deal_products_id = $deal_products['id'];

         $dealProducts = array(
            $name => array(
               'id' => $id,
               'name' => $name,
               'price' => $price,
               'qty' => $qty,
               'size' => $size,
               'type' => $type,
               'deal_products_id' => $deal_products_id,
            )
         );
         $_SESSION['deal_products'] = array_merge($_SESSION['deal_products'], $dealProducts);
      }
   }


   $deal_query = "SELECT * FROM deals WHERE id='$dealID' LIMIT 1";
   $result = mysqli_query($conn, $deal_query);
   $row = mysqli_fetch_assoc($result);

   if ($row) {
      // Retrieve individual field value
      $name = $row["deal_name"];
      $price = $row["deal_price"];
      $description = $row["deal_desc"];
      $photo = $row["photo"];
      $active_status = $row["active_status"];
   } else {
      echo '<script>window.location.href = "deals";</script>';
      exit();
   }
}



ob_end_flush();
