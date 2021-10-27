<?php
ob_start();

// require('./config/db.php');

// initializing variables
$categoryName;
$categoryDesc;
$restaurantID = $_SESSION['id'];
$errors   = array();
// array_push($errors, "JUST CHECKING");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form
   $categoryName = mysqli_real_escape_string($conn, trim($_POST['categoryName']));
   $categoryDesc = mysqli_real_escape_string($conn, trim($_POST['categoryDesc']));

   if (!empty($categoryName)) {
      // first check the database to make sure 
      // a category does not already exist with the same email 
      $restaurant_check_query = "SELECT category_name FROM categories 
      WHERE category_name='$categoryName' LIMIT 1";
      $result = mysqli_query($conn, $restaurant_check_query);
      $category = mysqli_fetch_assoc($result);

      if ($category) { // if category exists
         if ($category['email'] == $restaurantEmail) {
            array_push($errors, "category already exists try something else");
         }
      }
   }

   // form validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error into $errors array
   if (empty($categoryName)) {
      array_push($errors, "Category Name is required");
   }

   if (empty($categoryDesc)) {
      array_push($errors, "Category description is required");
   }

   // Finally, save Category if there are no errors in the form
   if (count($errors) == 0) {

      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `categories` 
      (`category_name`, `category_desc`, `created_at`, `restaurant_id`) 
      VALUES ('$categoryName', '$categoryDesc','$date', $restaurantID)";

      $results = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($results) {
         header('location: restaurantCategories');
         exit();
      }
   }
}
