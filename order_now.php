<?php

include("./includes/restaurants/orders/code.order_now.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php echo $row['name'] ?> | Order now</title>

   <link rel="shortcut icon" href="includes/restaurants/logos/<?php echo $row['logo'] ?> " type="image/x-icon">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<style>
   html {
      scroll-behavior: smooth;
   }

   .navbar {
      overflow: hidden;
      background-color: #fff;
      position: fixed;
      top: 0;
      width: 100%;
   }

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

   .sidenav {
      height: 100%;
      width: 100%;
      position: fixed;
      z-index: 1;
      top: 0;
      right: 0;
      background-color: #fff;
      overflow: hidden;
      padding-top: 20px;
   }

   .cart_table_main {
      max-height: 50%;
      overflow: auto;
   }

   .cart_table tr {
      cursor: pointer;
      font-size: 14px;
      margin: 10px 0;
   }

   .cart_table tbody tr td:first-child {
      width: 40%;
      font-size: 12px;
   }

   .cart_table tbody tr td:nth-child(2) {
      width: 30%;
      font-size: 12px;
   }

   .qty_minus,
   .qty_plus {
      margin: 0 4px;
      padding: 4px;
      color: #C49A6C;
      cursor: pointer;
   }

   .category_menu {
      background-color: #fff !important;
      position: fixed;
      z-index: 1;
      width: 75%;
   }

   .category_title {
      text-align: center;
      font-weight: bold;
   }

   .no-btn {
      border: none;
      background: none;
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
      background-color: rgba(0, 0, 0, 0.08);
      color: #373737;
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


   .quantity {
      position: relative;
   }

   input[type=number]::-webkit-inner-spin-button,
   input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
   }

   input[type=number] {
      -moz-appearance: textfield;
   }

   .quantity input {
      width: 75px;
      height: 42px;
      line-height: 1.65;
      float: left;
      display: block;
      padding: 0;
      margin: 0;
      padding-left: 20px;
      border: none;
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08);
      font-size: 1rem;
      border-radius: 4px;
   }

   .quantity input:focus {
      outline: 0;
   }

   .quantity-nav {
      float: left;
      position: relative;
      height: 42px;
   }

   .quantity-button {
      position: relative;
      cursor: pointer;
      border: none;
      border-left: 1px solid rgba(0, 0, 0, 0.08);
      width: 21px;
      text-align: center;
      color: #333;
      font-size: 13px;
      font-family: "FontAwesome" !important;
      line-height: 1.5;
      padding: 0;
      background: #FAFAFA;
      -webkit-transform: translateX(-100%);
      transform: translateX(-100%);
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      -o-user-select: none;
      user-select: none;
   }

   .quantity-button:active {
      background: #EAEAEA;
   }

   .quantity-button.quantity-up {
      position: absolute;
      height: 50%;
      top: 0;
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      font-family: "FontAwesome";
      border-radius: 0 4px 0 0;
      line-height: 1.6
   }

   .quantity-button.quantity-down {
      position: absolute;
      bottom: 0;
      height: 50%;
      font-family: "FontAwesome";
      border-radius: 0 0 4px 0;
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
      <div class="content-wrapper bg-white mt-5">
         <!-- Main content -->
         <div class="content">
            <div class="row">
               <div class="col-lg-9">
                  <div class="row fix_body">
                     <div class="col-lg-12 category_menu" style="padding:0px;">

                        <div class="scrollmenu py-2">
                           <?php
                           while ($row = mysqli_fetch_assoc($categories)) {
                              echo '<a class="btn py-0 m-1" href="#' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                           }
                           ?>

                        </div>
                     </div>
                  </div>
                  <br>

                  <div class="row" style="margin: 30px 30px;">

                     <div class="col-lg-12">

                        <div class="container-fluid mt-5">

                           <div class="product_main mt-5">

                              <?php
                              $query = "SELECT * FROM `categories` WHERE `restaurant_id` = $id";
                              $categories = mysqli_query($conn, $query);
                              while ($category = mysqli_fetch_assoc($categories)) {
                              ?>
                                 <h2 class="category_title my-4" id="<?php echo $category['category_name']; ?>">
                                    <?php echo $category['category_name']; ?></h2>

                                 <?php
                                 $query = "SELECT products.id, products.name as productName, categories.category_name as categoryName, products.description, products.price, products.photo, products.active_status FROM `products` JOIN categories on products.category_id = categories.id WHERE restaurant_id = $id AND products.active_status = 'active'  AND categories.active_status = 'active'";
                                 $products = mysqli_query($conn, $query);
                                 while ($product = mysqli_fetch_assoc($products)) {
                                    if ($product['categoryName'] == $category['category_name']) {
                                 ?>
                                       <div class="products">
                                          <div class="row">
                                             <div class="mx-4">
                                                <img class="img-lg" src='includes/restaurants/products/product_imgs/<?php echo $product['photo'] ?>'>
                                             </div>

                                             <div class="col-xl-6 col-lg-7 col-md-8 col-10">
                                                <h4 class="product_title"><?php echo $product['productName'] ?></h4>
                                                <p class="product_description"><?php echo $product['description'] ?></p>
                                             </div>
                                             <div class="col-xl-4 col-lg-3 col-md-12 mt-4">
                                                <div class="product_price text-right">
                                                   <span class="ml-2 mr-2">Rs. <?php echo $product['price'] ?></span>
                                                   <button type="button" class="no-btn" onclick="addToCart('<?php echo $product['id'] ?>')">
                                                      <i class="fas fa-plus add_btn add_to_cart_btn"></i>
                                                   </button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                 <?php
                                    }
                                 } ?>
                              <?php
                              } ?>

                           </div>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 elevation-1 sidenav">
                  <br>
                  <br>
                  <h1 class="text-center ">
                     Cart
                  </h1>
                  <div class="cart_table_main">
                     <table class="table table-hover cart_table">
                        <tbody>
                           <?php foreach ($_SESSION["order_cart"] as $product) { ?>

                              <tr>
                                 <td class="cart_item_name"><?php echo $product["name"]; ?></td>
                                 <td>
                                    <form action="" method="post">
                                       <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                       <input type='hidden' name='action' value="change" />
                                       <div class="quantity mt-2">
                                          <input type="number" name="quantity" min="1" step="1" value="<?php echo $product["quantity"] ?>" onchange="this.form.submit()">
                                       </div>
                                    </form>
                                 </td>
                                 <td class="cart_item_subtotal text-right">Rs. <?php echo $product["price"]; ?></td>
                                 <td>
                                    <div class="pl-2 float-right">
                                       <form method='post' action=''>
                                          <input type='hidden' name='key' value="<?php echo $product["id"]; ?>" />
                                          <input type='hidden' name='action' value="remove" />
                                          <button type='submit' class='remove btn btn-danger'>
                                             <span style='color:white;'>
                                                <i class='fas fa-trash-alt'></i>
                                             </span></button>
                                       </form>
                                    </div>
                                 </td>
                              </tr>

                           <?php
                           }
                           ?>
                        </tbody>
                     </table>
                  </div>
                  <div class="" style="height: 1000px;">
                     <br>

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

   <script>
      $(document).ready(function() {
         jQuery('<div class="quantity-nav"><button class="quantity-button quantity-up" ><span class="white"  ><i class="fas fa-angle-up" ></i></span></button><button class="quantity-button quantity-down" ><span class="white"><i  class="fas fa-angle-down"></i></span></button></div>').insertAfter('.quantity input');
         jQuery('.quantity').each(function() {
            var spinner = jQuery(this),
               input = spinner.find('input[type="number"]'),
               btnUp = spinner.find('.quantity-up'),
               btnDown = spinner.find('.quantity-down'),
               min = input.attr('min'),
               max = input.attr('max');

            btnUp.click(function() {
               var oldValue = parseFloat(input.val());
               if (oldValue >= max) {
                  var newVal = oldValue;
               } else {
                  var newVal = oldValue + 1;
               }
               spinner.find("input").val(newVal);
               spinner.find("input").trigger("change");
            });

            btnDown.click(function() {
               var oldValue = parseFloat(input.val());
               if (oldValue <= min) {
                  var newVal = oldValue;
               } else {
                  var newVal = oldValue - 1;
               }
               spinner.find("input").val(newVal);
               spinner.find("input").trigger("change");
            });

         });
      });

      function addToCart(id) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  productId: id
               },
            })
            .done(function(response) {
               if (response == 1) {
                  location.reload();
               }
               if (response == 0) {
                  Swal.fire('Alreay Exist!', "Product already in cart", "error");
               }
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong!', 'error');
            });
      }
   </script>
</body>

</html>