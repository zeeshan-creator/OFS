<?php

require('config/db.php');
if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo '<script>window.location.href = "index";</script>';
}
if (isset($_GET['id'])) {
   $id = trim($_GET['id']);
   $query = "SELECT * FROM restaurants WHERE id = $id";
   $results = mysqli_query($conn, $query);
   $rowNum = mysqli_num_rows($results);
   if ($rowNum > 0) {
      $row = mysqli_fetch_assoc($results);

      $query = "SELECT * FROM `categories` WHERE `restaurant_id` = $id";
      $categories = mysqli_query($conn, $query);
   } else {
      echo '<script>window.location.href = "index";</script>';
   }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>OFS | <?php echo $row['name'] ?> | Order now</title>

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<style>
   div.scrollmenu {
      overflow: auto;
      white-space: nowrap;
      box-shadow: .1px 2px 3px grey;
   }

   div.scrollmenu a {
      color: black !important;
      display: inline-block;
      color: white;
      text-align: center;
      text-decoration: none;
   }

   div.scrollmenu a:hover {
      /* background-color: #777; */
   }

   /* width */
   ::-webkit-scrollbar {
      width: 10px;
      height: 5px;
   }

   /* Track */
   ::-webkit-scrollbar-track {
      /* box-shadow: inset 0 0 3px grey; */
      /* border-radius: 5px; */
   }

   /* Handle */
   ::-webkit-scrollbar-thumb {
      background: rgba(30, 30, 30, 0.4);
      border-radius: 5px;
   }

   /* Handle on hover */
   ::-webkit-scrollbar-thumb:hover {
      background: grey;
   }

   .products {
      width: 100%;
      border-top: thin solid #eee;
      padding: 20px;
   }

   .products:last-child {
      border-bottom: thin solid #eee;
   }

   .products:hover {
      border: none;
      box-shadow: 1px 1px 15px #eee, -1px -1px 15px #eee;
   }

   .product_title {
      width: 100%;
      font-size: 17px;
      font-weight: bold;
   }

   .product_description {
      width: 100%;
      margin: 0;
      font-size: 14px;
      color: gray;
      font-style: italic;
   }

   .product_price {
      width: 100%;
      height: auto;
      text-align: right;
   }

   .add_btn {
      padding: 8px;
      background-color: #C49A6C;
      color: white;
      border-radius: 2px;
      cursor: pointer;
      transition: 0.2s all ease-in-out;
      -webkit-transition: 0.2s all ease-in-out;
      -moz-transition: 0.2s all ease-in-out;
      -ms-transition: 0.2s all ease-in-out;
      -o-transition: 0.2s all ease-in-out;
   }

   .add_btn:hover {
      box-shadow: 1px 1px 10px lightgray;
   }
</style>

<body class="hold-transition layout-top-nav">
   <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
         <div class="container">
            <a href="#" class="navbar-brand">
               <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
               <img src="includes/restaurants/logos/<?php echo $row['logo'] ?>" class="brand-image img-circle elevation-3" alt="Restaurant logo">
               <span class="brand-text font-weight-light"><?php echo $row['name'] ?></span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>

         </div>
      </nav>
      <!-- /.navbar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper bg-white">
         <!-- Main content -->
         <div class="content">
            <div class="row">
               <div class="col-lg-9">
                  <div class="row">
                     <div class="col-lg-12" style="padding:0px;">

                        <div class="scrollmenu py-3">
                           <?php
                           while ($row = mysqli_fetch_assoc($categories)) {
                              echo '<a class="btn py-0 m-1" data-filter="' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                           }
                           ?>

                        </div>
                     </div>
                  </div>


                  <div class="row" style="margin: 30px 30px;">
                     <div class="col-lg-12">


                        <div class="container-fluid mt-4">

                           <div class="products">
                              <div class="row">
                                 <div href="http://foodsinn.co/menu-and-ordering/public/media/product_images/1631789373.JPG" class="image-popup-no-margins product-img col-xl-2 col-lg-2 col-md-4 col-2">
                                    <img src="http://foodsinn.co/menu-and-ordering/public/media/product_thumbnails/1631789373.JPG">
                                 </div>

                                 <div class="col-xl-6 col-lg-7 col-md-8 col-10">
                                    <h4 class="product_title">Chicken Corn Soup (single)</h4>
                                    <p class="product_description">Pure chicken stock with chicken minced, and bits of corn.</p>
                                 </div>
                                 <div class=" col-xl-4 col-lg-3 col-md-12 ">
                                    <div class="product_price text-right">
                                       <span class="ml-2 mr-2">Rs. 280</span>
                                       <i class="fas fa-plus add_btn add_to_cart_btn"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>


                     </div>
                  </div>

               </div>
               <div class="col-lg-3 elevation-1">
                  <div class="" style="height: 1000px;">
                     <h1 class="text-center mt-2">
                        Cart
                     </h1>
                     <hr>
                     <div class="row">

                        <div class="col-lg-6">
                           <h5 class="float-left pl-3">Delivery area</h5>
                        </div>
                        <div class="col-lg-6">
                           <h5 class="float-right pr-3">Azam basti</h5>
                        </div>

                     </div>

                     <div class="row mt-1 mb-0">

                        <div class="col-lg-6">
                           <h5 class="float-left pl-3">Subtotal</h5>
                        </div>
                        <div class="col-lg-6">
                           <h5 class="float-right pr-3">00.00</h5>
                        </div>

                     </div>
                     <div class="row mb-2">

                        <div class="col-lg-6">
                           <h5 class="float-left pl-3">Delivery Charges</h5>
                        </div>
                        <div class="col-lg-6">
                           <h5 class="float-right pr-3">150.00</h5>
                        </div>

                     </div>
                     <div class="row">

                        <div class="col-lg-6">
                           <h5 class="float-left pl-3 font-weight-bolder">Total <small style="font-size: 12px;">(incl. GST)</small></h5>
                        </div>
                        <div class="col-lg-6">
                           <h5 class="float-right pr-3">150.00</h5>
                        </div>

                     </div>
                     <div class="row text-center mt-3">

                        <div class="col-lg-6">
                           <input type="button" value="Delivery" class="btn btn-light bg-white px-5 elevation-2 font-weight-bold">
                        </div>
                        <div class="col-lg-6">
                           <input type="button" value="Take away" class="btn btn-light bg-white px-5 elevation-2 font-weight-bold">
                        </div>

                     </div>
                  </div>
               </div>

            </div>
         </div>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
         <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->

      <!-- Main Footer -->
      <footer class="main-footer">
         <!-- To the right -->
         <div class="float-right d-none d-sm-inline">
            Anything you want
         </div>
         <!-- Default to the left -->
         <strong>Powered By <a href="https://octopusdigitalnetwork.com">Octopus Digital Network</a>.</strong> All rights reserved.
      </footer>
   </div>
   <!-- ./wrapper -->

   <!-- REQUIRED SCRIPTS -->

   <!-- jQuery -->
   <script src="plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap 4 -->
   <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>