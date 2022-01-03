<?php
$subTotal = 0;
$deliveryCharges = 0;
$numOfQty = 0;
$total = 0;

if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo "branchID is missing from the url parameters";
   exit;
}

include("./includes/restaurants/orders/code.checkOut.php");

if (isset($_GET['id'])) {
   $id = trim($_GET['id']);
   $query = "SELECT * FROM restaurants WHERE id = $id";
   $results = mysqli_query($conn, $query);
   $rowNum = mysqli_num_rows($results);
   if ($rowNum > 0) {
      $row = mysqli_fetch_assoc($results);
      $resID = $row['id'];

      $query = "SELECT * FROM `customers` WHERE `id` = " . $_SESSION['userId'];
      $result = mysqli_query($conn, $query);
      $user = mysqli_fetch_assoc($result);

      if ($user) {
         // Retrieve individual field value
         $userId = $user["id"];
         $userName = $user["full_name"];
         $userEmail = $user["email"];
         $userPhone = $user["phone"];
         $userAddress = $user['address'];
      }

      // $query = "SELECT * FROM `delivery_zone` WHERE `restaurant_id` = $id";
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
   @media (max-width: 1200px) {
      .checkout_section {
         width: 90%;
      }
   }

   .checkout_section {
      width: 80%;
      margin: 80px auto;
   }

   .checkout_fields {
      float: left;
      width: 60%;
      padding: 20px;
   }

   .checkout_form {
      width: 100%;
      height: 100%;
      padding: 20px;
   }

   .checkout_cart {
      float: left;
      width: 40%;
      padding: 20px;
   }

   .checkout_cart_indiv {
      width: 100%;
      min-height: 400px !important;
      height: 100%;
      box-shadow: 1px 1px 10px #d3d3d3;
      padding: 16px 10px;
   }

   .checkout_cart_indiv h4 {
      width: 100%;
      padding: 0 16px;
      font-size: 28px;
   }

   .coupon_indiv {
      display: flex;
   }

   .coupon_div {
      width: 100%;
      height: auto;
      padding: 20px;
      font-size: 12px;
   }

   .coupon_indiv .btn {
      flex: 1;
      font-size: 12px;
      border-radius: 40px !important;
   }

   .coupon_discount {
      width: 100%;
      text-align: right;
      font-weight: 600;
      font-size: 14px;
      padding: 10px;
      display: none;
   }

   .confirm_order {
      width: 100%;
      padding: 10px;
   }

   .back_to_cart {
      color: black;
      float: right;
      padding: 8px 0;
      font-size: 14px;
      font-weight: 600;
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
      <div class="content-wrapper bg-white">
         <!-- Main content -->
         <div class="content">
            <div class="row">
               <div class="col-lg-12">

                  <div class="checkout_section">

                     <div class="checkout_fields">
                        <div class="checkout_form">
                           <form class="form" id="order_form" action="" class="needs-validation" method="post">
                              <input type="hidden" name="_token" value="<?php echo $userId ?>">
                              <h4>Checkout Form</h4>
                              <br>

                              <div class="form-group">
                                 <label>Full Name <span class="text-danger font-weight-bold">*</span></label>
                                 <input type="text" required="" value="<?php echo $userName ?>" name="customerName" placeholder="Please Enter Full Name" class="form-control">
                              </div>

                              <div class="form-group">
                                 <label>Area <span class="text-danger font-weight-bold">*</span></label>
                                 <select class="form-control" name="customerArea" required="">
                                    <option data-area="Please Select Delivery Zone" value="0">Please Select Delivery Area</option>
                                    <?php
                                    while ($area = mysqli_fetch_assoc($areas)) {
                                       echo "<option value='" . $area['id'] . "'>" . $area['area'] . "</option>";
                                    }
                                    ?>
                                 </select>
                              </div>

                              <div class="form-group">
                                 <label>Street Address <span class="text-danger font-weight-bold">*</span></label>
                                 <input type="text" required="" value="<?php echo $userAddress ?>" name="customerAdress" placeholder="Please Enter Street Address" class="form-control">
                              </div>
                              <div class="form-group">
                                 <label>Nearest Landmark <span class="text-danger font-weight-bold">*</span></label>
                                 <input type="text" style="margin-top:10px;" name="customerNearestPlace" placeholder="Please Enter Landmark" class="form-control landmark_other">
                              </div>

                              <div class="form-group">
                                 <label>Mobile Number <span class="text-danger font-weight-bold">*</span></label>
                                 <input type="number" required="" value="<?php echo $userPhone ?>" name="customerPhone" placeholder="03XXXXXXXXX" class="form-control checkout_number">
                                 <span class="text-danger d-none">Invalid Number</span>
                              </div>

                              <div class="form-group">
                                 <label>Email </label>
                                 <input type="email" name="customerEmail" value="<?php echo $userEmail ?>" placeholder="Please Enter Email" class="form-control">
                              </div>

                              <div class="form-group">
                                 <label>Order Instructions / Note to rider </label>
                                 <textarea name="orderNote" class="form-control" name="order_instructions" maxlength="200" placeholder="Please Enter Order Instructions / Note to rider "></textarea>

                              </div>
                              <input type="hidden" value="" name="total_price" id="total">
                              <input type="hidden" value="<?php echo $userId ?>" name="customer_id" id="userID">
                           </form>
                        </div>
                     </div>

                     <div class="checkout_cart">
                        <div class="checkout_cart_indiv">
                           <h4>Cart <a href="order_now?id=<?php echo $resID ?>" class="back_to_cart"><i class="fas fa-shopping-cart" aria-hidden="true"></i> Back To Cart</a></h4>
                           <div class="checkout_cart_table_main">
                              <table class="table checkout_cart_table table-responsive" style="display: table;">
                                 <thead>
                                    <tr>
                                       <th>Item</th>
                                       <th>Qty</th>
                                       <th>Price</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (isset($_SESSION["order_cart"])) {
                                       foreach ($_SESSION["order_cart"] as $product) { ?>
                                          <tr>
                                             <td><?php echo $product["name"]; ?></td>
                                             <td><?php echo $product["quantity"]; ?></td>
                                             <td><?php echo $product["price"]; ?></td>
                                          </tr>
                                    <?php
                                          $subTotal += ($product["price"] * $product["quantity"]);
                                          $numOfQty += $product["quantity"];

                                          if ($subTotal >= $free_delivery_over) {
                                             $deliveryCharges = 0;
                                          }
                                       }
                                    }
                                    ?>

                                    <tr>
                                       <td>Subtotal</td>
                                       <td><?php echo $numOfQty; ?></td>
                                       <td><?php echo $subTotal; ?></td>
                                    </tr>

                                    <?php if ($deliveryCharges >= 0) : ?>
                                       <tr>
                                          <td>Delivery Charges</td>
                                          <td></td>
                                          <td><?php echo $deliveryCharges; ?></td>
                                       </tr>
                                    <?php endif ?>

                                 </tbody>
                              </table>
                           </div>

                           <div class="coupon_div">
                              <h6>Coupon</h6>
                              <div class="coupon_indiv">
                                 <input type="text" name="coupon" class="form-control" id="coupon_code" placeholder="Please Enter Coupon Code Here">
                                 <button class="btn btn-primary btn-rounded coupon_apply_btn ml-2">Apply</button>

                              </div>
                              <p class="coupon_message"></p>


                           </div>
                           <div class="coupon_discount">
                              <p>Coupon Discount:&nbsp; <span>Rs. <span>250</span></span></p>
                           </div>

                           <div class="coupon_div">
                              <p>Payment Method <span class="text-danger font-weight-bold">*</span></p>
                              <dd class="pl-2">
                                 <div class="radio">
                                    <label><input type="radio" name="payment" value="1" checked=""> Cash on delivery</label>
                                 </div>

                                 <!-- <div class="radio">
                                    <label><input type="radio" name="payment" value="2"> Card payment</label>
                                 </div> -->
                                 <span class="text-danger select-payment-error d-none">Please select payment method</span>
                              </dd>
                           </div>


                           <div class="confirm_order">
                              <button class="btn btn-primary btn-block btn_confirm">
                                 <?php $total = $subTotal + $deliveryCharges;
                                 echo '<script> document.getElementById("total").value = "' . $total . '"; </script>';
                                 ?>
                                 <span>Confirm Order</span> <span>Total: Rs. <span class="checkout_total"><?php echo $total; ?></span></span>
                              </button>
                           </div>

                        </div>

                     </div>
                  </div>
               </div>

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
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
         'use strict';
         window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
               form.addEventListener('submit', function(event) {
                  if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                  }
                  form.classList.add('was-validated');
               }, false);
            });
         }, false);
      })();

      $(document).ready(function() {
         if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
         }
         $(".btn_confirm").click(function() {
            $("#order_form").submit()
         });
      });
   </script>
</body>

</html>