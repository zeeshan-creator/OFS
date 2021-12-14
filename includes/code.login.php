<?php
ob_start();
session_start();

require('./config/db.php');


// initializing variables
$email;
$password;
$errors   = array();


if (isset($_SESSION['name'])) {
   header("Location: index");
   exit();
}

// LOGIN USER
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   if (empty($email)) {
      array_push($errors, "Email is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }

   // run if entered email, password is in admin's table
   $query = "SELECT * FROM admin WHERE email='$email' limit 1";
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   if (mysqli_num_rows($results) == 1) {
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }

      if ($row["password"] == $password) {
         if ($row["active_status"] !== "active") {
            array_push($errors, "Your Account is Not Inactive, Please Contact the Administration");
         }
      }

      if (count($errors) == 0) {
         userLogin('admin', $email, $conn);
      }
   }

   // run if entered email, password is in restaurant's table
   $query = "SELECT * FROM restaurants WHERE email='$email' limit 1";
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   if (mysqli_num_rows($results) == 1) {
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }

      if ($row["password"] == $password) {
         if ($row["active_status"] !== "active") {
            array_push($errors, "Your Account is Not Inactive Please Contact the Administration");
         }
      }
      if (count($errors) == 0) {
         userLogin('restaurants', $email, $conn);
      }
   }

   // run if entered email, password is in sub_restaurant's table
   $query = "SELECT * FROM sub_restaurants WHERE email='$email' limit 1";
   $results = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($results);

   if (mysqli_num_rows($results) == 1) {
      if ($row["password"] !== $password) {
         array_push($errors, "Password is Wrong");
      }

      if ($row["password"] == $password) {
         if ($row["active_status"] !== "active") {
            array_push($errors, "Your Account is Not Inactive Please Contact the Administration");
         }
      }
      if (count($errors) == 0) {
         userLogin('sub_restaurants', $email, $conn);
      }
   }

   if (count($errors) == 0) {
      if (!empty($email) && !empty($password)) {
         array_push($errors, "Your Email Does Not Exist");
      }
   }
}

function userLogin($db, $email, $conn)
{
   $query = "SELECT * FROM $db WHERE email='$email' LIMIT 1";
   $results = mysqli_query($conn, $query);

   if (mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
      $_SESSION['name'] = $row["name"];
      $_SESSION['email'] = $row["email"];
      if ($row["logo"]) {
         $_SESSION['logo'] = $row["logo"];
      }
      $_SESSION['role'] = $row["role"];
      $_SESSION['id'] = $row["id"];
      $_SESSION['active_status'] = $row["active_status"];
      $date = date('Y-m-d H:i:s');
      $query = "UPDATE $db set `last_login` = '$date' WHERE `email`= '$email'";
      mysqli_query($conn, $query) or die(mysqli_error($conn));
      header('location: index');
      exit();
   }
};

ob_end_flush();

// ...
