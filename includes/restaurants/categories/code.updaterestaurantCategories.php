<?php
ob_start();

// initializing variables
$category_name;
$category_desc;
$categoryId;
$errors   = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $category_name = mysqli_real_escape_string($conn, trim($_POST['category_name']));
   $category_desc = mysqli_real_escape_string($conn, trim($_POST['category_desc']));
   $categoryId = mysqli_real_escape_string($conn, trim($_POST['categoryId']));

   if (!empty($category_name)) {
      // first check the database to make sure 
      // a user does not already exist with the same email 
      $category_name_check_query = "SELECT category_name,id FROM categories WHERE category_name='$category_name' LIMIT 1";
      $result = mysqli_query($conn, $category_name_check_query);
      $category = mysqli_fetch_assoc($result);

      if ($category) { // if category exists
         if ($category['id'] != $categoryId) {
            if ($category['category_name'] == $category_name) {
               array_push($errors, "category name already exists try something else");
            }
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($category_name)) {
      array_push($errors, "category Name is required");
   }

   if (empty($category_desc)) {
      array_push($errors, "category description is required");
   }

   // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "UPDATE `categories` SET 
         `category_name` = '$category_name', 
         `category_desc` = '$category_desc',
         `updated_at` = '$date'
         WHERE `categories`.`id` = $categoryId";

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
         echo '<script>window.location.href = "restaurantCategories";</script>';
         exit();
      }
   }
}
