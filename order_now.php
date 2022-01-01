<?php
$subTotal = 0;
$deliveryCharges = 0;
$total = 0;

if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo "branchID is missing from the url parameters";
   exit;
}

include("./includes/restaurants/orders/code.order_now.php");

if (isset($_GET['id'])) {
   $id = trim($_GET['id']);
   $query = "SELECT * FROM restaurants WHERE id = $id";
   $results = mysqli_query($conn, $query);
   $rowNum = mysqli_num_rows($results);
   if ($rowNum > 0) {
      $row = mysqli_fetch_assoc($results);

      $query = "SELECT * FROM `categories` WHERE `restaurant_id` = $id";
      $categories = mysqli_query($conn, $query);

      $query = "SELECT * FROM `areas`";
      $areas = mysqli_query($conn, $query);

      $restaurant_query = "SELECT * FROM `delivery_settings` WHERE `restaurant_id` = '$id'";
      $result = mysqli_query($conn, $restaurant_query);
      $settings = mysqli_fetch_assoc($result);

      if ($settings) {
         // Retrieve individual field value
         $min_delivery = $settings["min_delivery"];
         $min_pickup = $settings["min_pickup"];
         $deliveryCharges = $settings["delivery_charges"];
         $free_delivery_over = $settings["free_delivery_over"];
         $tax = $settings['tax'];
         $delivery_time = $settings['delivery_time'];
      }
   } else {
      echo '<script>alert("branchID in the parameters is not found!");</script>';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php echo $row['name'] ?> | Order now</title>

   <link rel="shortcut icon" href="includes/restaurants/logos/<?php echo $row['logo'] ?> " type="image/x-icon">
   <!-- Font Awesome Icons -->
   <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
   <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->

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

   .zoneTags {
      padding: 5px;
      width: 50%;
      min-height: 120px;
      max-height: fit-content;
      border: thin solid grey
   }

   .tag {
      margin: 5px;
      background-color: rgba(0, 0, 0, .2);
      padding: 2px 5px;
      border-radius: 3px;
      border: thin solid grey;
   }

   .areas {
      height: 500px;
      overflow-y: auto;
   }

   .areas p:hover {
      box-shadow: 1px 1px 4px;
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

   .mt-6 {
      margin-top: 55px;
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

   #areaTitle {
      border: none;
      padding: 0px 10px;
      -webkit-appearance: none;
      text-decoration: underline;
   }

   #areaTitle:hover {
      color: rgba(0, 0, 0, .5)
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
               <img src="includes/restaurants/logos/<?php echo $row['logo'] ?>" class="brand-image img-circle elevation-3" alt="Restaurant logo">
               <span class="brand-text font-weight-light"><?php echo $row['name'] ?></span>
            </a>

            <?php
            if (!isset($_SESSION['userName'])) {
            ?>
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="userLogin?branchID=<?php echo $row['id'] ?>">Login / Sign Up</a>
                  </li>
               </ul>
            <?php
            }
            ?>
            <?php
            if (isset($_SESSION['userName'])) {
            ?>
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="userLogout">Logout</a>
                  </li>
                  <li class="nav-item" style="cursor: pointer;">
                     <a class="nav-link" data-toggle="modal" data-target="#profileModal"><i class="fas fa-user-circle"></i> Profile</a>
                  </li>
               </ul>
            <?php
            }
            ?>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>

         </div>
      </nav>
      <!-- /.navbar -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper bg-white mt-6">
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
                           <a class="btn py-0 m-1" href="#deals">Deals</a>
                           <a class="btn py-0 m-1" href="#addons">Addons</a>
                        </div>
                     </div>
                  </div>
                  <br>

                  <div class="row" style="margin: 30px 30px;">

                     <div class="col-lg-12">

                        <div class="container-fluid mt-5">

                           <div class="product_main mt-5">

                              <!-- For  Products -->

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
                                                <img class="img-lg" src=' includes/restaurants/products/product_imgs/<?php echo $product['photo'] ?>'>
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

                              <!-- For  Deals-->
                              <?php
                              $query = "SELECT deals.id, deals.deal_name, deals.photo, deals.deal_desc, deals.deal_price FROM `deals` JOIN restaurants on deals.restaurant_id = restaurants.id WHERE restaurant_id = $id AND deals.active_status = 'active'  AND restaurants.active_status = 'active'";
                              $deals = mysqli_query($conn, $query);
                              $rowNum = mysqli_num_rows($deals);
                              if ($rowNum > 0) {
                                 echo '<h2 class="category_title my-4" id="deals">Deals</h2>';
                              }
                              while ($deal = mysqli_fetch_assoc($deals)) {
                              ?>
                                 <div class="products">
                                    <div class="row">
                                       <div class="mx-4">
                                          <img class="img-lg" src="includes/restaurants/deals/deals_imgs/<?php echo $deal['photo'] ?>">
                                       </div>

                                       <div class="col-xl-6 col-lg-7 col-md-8 col-10">
                                          <h4 class="deal_title"><?php echo $deal['deal_name'] ?></h4>
                                          <p class="deal_description"><?php echo $deal['deal_desc'] ?></p>
                                       </div>
                                       <div class="col-xl-4 col-lg-3 col-md-12 mt-4">
                                          <div class="deal_price text-right">
                                             <span class="ml-2 mr-2">Rs. <?php echo $deal['deal_price'] ?></span>
                                             <button type="button" class="no-btn" onclick="addDealToCart('<?php echo $deal['id'] ?>')">
                                                <i class="fas fa-plus add_btn add_to_cart_btn"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              <?php
                              } ?>

                              <!-- For  Addons -->
                              <?php
                              $query = "SELECT addons_products.id, addons_products.photo, addons_products.name, addons_products.description, addons_products.price FROM `addons_products` JOIN restaurants on addons_products.restaurant_id = restaurants.id WHERE restaurant_id = $id AND addons_products.active_status = 'active'  AND restaurants.active_status = 'active'";
                              $addons = mysqli_query($conn, $query);
                              $rowNum = mysqli_num_rows($addons);
                              if ($rowNum > 0) {
                                 echo '<h2 class="category_title my-4" id="addons">Addons</h2>';
                              }
                              while ($addon = mysqli_fetch_assoc($addons)) {
                              ?>
                                 <div class="products">
                                    <div class="row">
                                       <div class="mx-4">
                                          <img class="img-lg" src="includes/restaurants/addon_products/addons_imgs/<?php echo $addon['photo'] ?>">
                                       </div>

                                       <div class="col-xl-6 col-lg-7 col-md-8 col-10">
                                          <h4 class="addon_title"><?php echo $addon['name'] ?></h4>
                                          <p class="addon_description"><?php echo $addon['description'] ?></p>
                                       </div>
                                       <div class="col-xl-4 col-lg-3 col-md-12 mt-4">
                                          <div class="addon_price text-right">
                                             <span class="ml-2 mr-2">Rs. <?php echo $addon['price'] ?></span>
                                             <button type="button" class="no-btn" onclick="addAddonToCart('<?php echo $addon['id'] ?>')">
                                                <i class="fas fa-plus add_btn add_to_cart_btn"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              <?php
                              } ?>

                           </div>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 elevation-1 sidenav" id="sidenav">
                  <br>
                  <br>
                  <h1 class="text-center ">
                     Cart
                  </h1>
                  <div class="cart_table_main">
                     <table class="table table-hover cart_table" id="cart_table">
                        <tbody>
                           <?php if (isset($_SESSION["order_cart"])) {
                              foreach ($_SESSION["order_cart"] as $product) { ?>
                                 <tr>
                                    <td class="cart_item_name"><?php echo $product["name"]; ?></td>
                                    <td>
                                       <div class="quantity mt-2">
                                          <input type="number" name="quantity" min="1" step="1" value="<?php echo $product["quantity"] ?>" onchange="changeCart('<?php echo $product['id']; ?>', this.value)">
                                       </div>

                                    </td>
                                    <td class="cart_item_subtotal text-right">Rs. <?php echo $product["price"]; ?></td>
                                    <td>
                                       <div class="pl-2 float-right">
                                          <button type='submit' onclick="removeFromCart('<?php echo $product['id']; ?>')" class='remove btn btn-default'>
                                             <span style='color:grey;'>
                                                <i class='fas fa-trash-alt'></i>
                                             </span></button>
                                       </div>
                                    </td>
                                 </tr>
                           <?php
                                 $subTotal += ($product["price"] * $product["quantity"]);

                                 if ($subTotal >= $free_delivery_over) {
                                    $deliveryCharges = 0;
                                 }
                              }
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
                           <input type="hidden" name="deliveryArea" id="deliveryArea">
                           <h5 class="pr-3" id="areaTitle" data-toggle="modal" data-target="#zonesModal">
                              Select Area
                           </h5>
                        </div>

                     </div>

                     <div class="" id="prices">

                        <div class="row mt-1 mb-0">

                           <div class="col-lg-6">
                              <h5 class="float-left pl-3">Subtotal</h5>
                           </div>
                           <div class="col-lg-6">
                              <h5 class="float-right pr-3"><?php echo $subTotal ?  $subTotal : "00.00" ?></h5>
                           </div>

                        </div>
                        <div class="row mb-2">

                           <div class="col-lg-6">
                              <h5 class="float-left pl-3">Delivery Charges</h5>
                           </div>
                           <div class="col-lg-6">
                              <h5 class="float-right pr-3"><?php echo $deliveryCharges ?  $deliveryCharges : "00.00" ?></h5>
                           </div>

                        </div>
                        <div class="row">

                           <div class="col-lg-6">
                              <h5 class="float-left pl-3 font-weight-bolder">Total <small style="font-size: 12px;">(incl. GST)</small></h5>
                           </div>
                           <div class="col-lg-6">
                              <?php $total = $subTotal + $deliveryCharges ?>
                              <h5 class="float-right pr-3"><?php echo $total ?  $total : "00.00" ?></h5>
                           </div>

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

               <!-- zonesModal  -->
               <div class="modal fade" id="zonesModal">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Delivery Zones</h4>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="areas">

                              <?php
                              while ($area = mysqli_fetch_assoc($areas)) {
                                 echo "<p><button class='no-btn w-100'
                                  onclick='selectArea(\"" . $area['area'] . "\")'>"
                                    . $area['area'] . "</button></p>";
                              }
                              ?>
                           </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.modal -->


               <!-- profileModal -->
               <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           ...
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.modal -->

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
      <!-- <footer class="main-footer">
         <div class="float-right d-none d-sm-inline">
            Anything you want
         </div>
         <strong>Powered By <a href="https://octopusdigitalnetwork.com">Octopus Digital Network</a>.</strong> All rights reserved.
      </footer> -->
   </div>
   <!-- ./wrapper -->

   <!-- REQUIRED SCRIPTS -->

   <!-- jQuery -->
   <script src="plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap 4 -->
   <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

   <script>
      $(document).ready(function() {
         if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
         }
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

      function selectArea(newVal) {
         var areaTitle = document.getElementById('areaTitle');
         var deliveryArea = document.getElementById('deliveryArea');
         areaTitle.innerText = newVal;
         deliveryArea.value = newVal;
         $("#zonesModal").modal("hide");
         $.ajax({
            url: 'order_now',
            type: 'POST',
            data: {
               selectedZone: newVal
            },
         })
      }

      function removeFromCart(id) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  key: id,
                  action: 'remove'
               },
            })
            .done(function(response) {
               $("#cart_table").load(window.location.href + " #cart_table");
               $("#prices").load(window.location.href + " #prices");
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong! Please try again', 'error');
            });
      }

      function changeCart(id, quantity) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  id: id,
                  action: 'change',
                  quantity: quantity
               },
            })
            .done(function(response) {
               $("#prices").load(window.location.href + " #prices");
               $("#cart_table").load(window.location.href + " #cart_table");
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong! Please try again', 'error');
            });
      }


      function addToCart(id) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  productId: id
               },
            })
            .done(function(response) {
               $("#prices").load(window.location.href + " #prices");
               $("#cart_table").load(window.location.href + " #cart_table");
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong! Please try again', 'error');
            });
      }

      function addDealToCart(id) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  dealID: id
               },
            })
            .done(function(response) {
               $("#prices").load(window.location.href + " #prices");
               $("#cart_table").load(window.location.href + " #cart_table");
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong!', 'error');
            });
      }

      function addAddonToCart(id) {
         $.ajax({
               url: 'orderCart',
               type: 'POST',
               data: {
                  addonID: id
               },
            })
            .done(function(response) {
               $("#prices").load(window.location.href + " #prices");
               $("#cart_table").load(window.location.href + " #cart_table");
            })
            .fail(function() {
               swal('Oops...', 'Something went wrong!', 'error');
            });
      }
   </script>
</body>

</html>