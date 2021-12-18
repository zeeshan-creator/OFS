<?php
ob_start();

// initializing variables
$name;
$link;
$active_status;
$linkId;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $name = mysqli_real_escape_string($conn, trim($_POST['name']));
   $link = mysqli_real_escape_string($conn, trim($_POST['link']));
   $active_status = mysqli_real_escape_string($conn, trim($_POST['active_status']));
   $linkId = mysqli_real_escape_string($conn, trim($_POST['linkID']));

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($name)) {
      array_push($errors, "Name is required");
   }

   if (empty($link)) {
      array_push($errors, "link is required");
   }

   if (empty($active_status)) {
      array_push($errors, "active status is required");
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `social_media_links` SET 
         `name` = '$name', 
         `link` = '$link',
         `active_status` = '$active_status',
         `updated_at` = '$date'
         WHERE `social_media_links`.`id` = $linkId";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         $id;
         if (isset($_GET['branchId'])) {
            $id = trim($_GET['branchId']);
            if ($_SESSION['role'] == 'admin') {
               header("location: restaurantDetails?id=$id");
               exit();
            }
         }
         echo '<script>window.location.href = "social_media_links";</script>';
         exit();
      }
   }
}
