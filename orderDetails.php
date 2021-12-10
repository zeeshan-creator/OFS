<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';

include("./includes/restaurants/POS/code.fetchCategoriesToPOS.php");
include("./includes/restaurants/POS/code.fetchProductsToPOS.php");
include("./includes/restaurants/POS/code.fetchDealsToPOS.php");
include("./includes/restaurants/POS/code.updateOrders.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>
<style>
  .imgbgchk:checked+label>.tick_container {
    opacity: 1;
  }

  /* ANIMATION */
  .imgbgchk:checked+label>img {
    opacity: 0.3;
  }

  .tick_container {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 35%;
    left: 58%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    cursor: pointer;
    text-align: center;
  }

  .tick {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    padding: 6px 12px;
    height: 40px;
    width: 40px;
    border-radius: 100%;
  }

  hr {
    border: none;
    border-top: 3px double #333;
    color: #333;
    overflow: visible;
    text-align: center;
    height: 5px;
  }

  hr:after {
    background: #fff;
    content: '§';
    padding: 0 4px;
    position: relative;
    top: -13px;
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

<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="wrapper">

    <!-- Navbar -->
    <?php include './partials/nav.php' ?>
    <!-- End Navbar -->


    <!-- Main Sidebar Container -->
    <?php include './partials/sidebar.php' ?>
    <!-- END Sidebar Container -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-2">
      <div class="container-fluid">
        <div class="row">

          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Order Details</h4>
              </div>
              <div class="card-body">
                <div class="row">

                  <div class="col-lg-8">
                    <form method="POST" action="" id="ordersForm" class="needs-validation" novalidate>

                      <div class="row">
                        <div class="col-lg-12 mb-4">
                          <!-- radio -->
                          <h2>Order Type</h2>

                          <div class="col-lg-6">
                            <div class="container parent">
                              <div class="row">
                                <div class='col form-check text-center'>
                                  <input type="hidden" name="id" value="<?php echo trim($_GET['orderID']) ?>">
                                  <input type="hidden" name="action" value="updateOrder">
                                  <input type="radio" name="orderType" value="Pick_Up" id="img2" class="d-none imgbgchk form-check-input" required <?php echo ($order_type == 'Pick_Up') ?  'checked' : '' ?>>
                                  <label for="img2" class="form-check-label" for="img2">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/element_our/20200610/ourlarge/pngtree-catering-takeaway-icon-image_2245469.jpg" alt="Image 2">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Pick Up
                                  </label>
                                </div>
                                <div class='col form-check text-center '>
                                  <input type="radio" name="orderType" value="Delivery" id="img1" class="d-none imgbgchk form-check-input" required <?php echo ($order_type == 'Delivery') ?  'checked' : '' ?>>
                                  <label for="img1" class="form-check-label" for="img1">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-vector/20200417/ourlarge/pngtree-delivery-boy-with-mask-riding-bike-vector-png-image_2187935.jpg" alt="Image 1">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Delivery
                                  </label>
                                </div>
                                <div class='col form-check text-center'>
                                  <input type="radio" name="orderType" value="Dine_In" id="img3" class="d-none imgbgchk form-check-input" required <?php echo ($order_type == 'Dine_In') ?  'checked' : '' ?>>
                                  <label for="img3" class="form-check-label" for="img3">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-vector/20190116/ourlarge/pngtree-vegetable-salad-food-vegetables-vegetable-salad-food-pattern-png-image_388734.jpg" alt="Image 3">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Dine In
                                  </label>
                                </div>
                                <div class='col form-check text-center'>
                                  <input type="radio" name="orderType" value="Drive_Thru" id="img4" class="d-none imgbgchk form-check-input" required <?php echo ($order_type == 'Drive_Thru') ?  'checked' : '' ?>>
                                  <label for="img4" class="form-check-label" for="img4">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-clipart/20191119/ourlarge/pngtree-drive-in-movie-signage-png-image_1993590.jpg" alt="Image 4">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Drive Thru
                                  </label>
                                  <div class="invalid-feedback">
                                    Please select an order name
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <h2>Customer Details</h2>
                      <div class="col-lg-12">

                        <input type="hidden" name="total_price" id="totalPrice" value="">
                      </div>
                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="customername">Customer's Name <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="text" class="form-control" value="<?php echo $customer_name ?>" name="customerName" id="customername" placeholder="Name">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="customerPhone">Customer's Phone <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="number" name="customerPhone" value="<?php echo $customer_phone ?>" class="form-control" id="customerPhone" placeholder="Phone">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="customerEmail">Customer's Email <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="email" name="customerEmail" value="<?php echo $customer_email ?>" class="form-control" id="customerEmail" placeholder="Email">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="orderNote">Special instructions <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="text" name="orderNote" value="<?php echo $order_note ?>" class="form-control" id="orderNote" placeholder="Order Note">
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>

                  <div class="col-lg-4 mb-4">
                    <h2 class="">Cart
                      <?php
                      if (!empty($_SESSION["order_products"])) {
                        $cart_count = count(array_keys($_SESSION["order_products"]));
                      ?>
                        : <span><?php echo $cart_count; ?></span>
                      <?php
                      }
                      ?>
                    </h2>

                    <?php if (empty($_SESSION["order_products"])) : ?>
                      <div class="text-center my-4">
                        <i class="text-black-50 fas fa-cart-plus" style="font-size:20px"></i>
                        <p>
                          Your cart is empty <br>
                          Add product to get started </p>
                      </div>
                    <?php endif ?>

                    <?php if (!empty($_SESSION["order_products"])) : ?>
                      <div class="">
                        <table>
                          <thead>
                            <tr class="text-bold">
                              <td></td>
                              <td class="pl-2">ITEM</td>
                              <td class="pl-4">QTY</td>
                              <td class="pl-4">PKR</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($_SESSION["order_products"] as $product) {
                            ?>
                              <tr>
                                <td style='width:60px;height:50px' class="text-center">
                                  <?php if ($product['type'] == 'product') : ?>
                                    <img src='includes/restaurants/products/product_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                                  <?php endif ?>
                                  <?php if ($product['type'] == 'deal') : ?>
                                    <h2 class="border">D<span style="font-size: 17px;font-weight: bold;">EAL</span></h2>
                                  <?php endif ?>
                                </td>
                                <td class="pl-2">
                                  <div class="float-left mr-4">
                                    <?php echo $product["name"]; ?><br />
                                  </div>
                                </td>
                                <td>
                                  <form action="" method="post">
                                    <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                    <input type='hidden' name='type' value="<?php echo $product["type"]; ?>" />
                                    <input type='hidden' name='action' value="change" />
                                    <div class="quantity mt-2">
                                      <input type="number" name="quantity" min="1" step="1" value="<?php echo $product["quantity"] ?>" onchange="this.form.submit()">
                                    </div>
                                    <?php if ($product['type'] != 'deal') : ?>
                                      <div class="">
                                        <select name="size" onchange="this.form.submit()" class="form-select w-100 border mt-1 mb-2" aria-label="Default select example">
                                          <option selected disabled>Sizes</option>
                                          <?php
                                          include("./includes/restaurants/POS/code.fetchSizesToPOS.php");
                                          while ($row = mysqli_fetch_assoc($sizes)) {
                                            echo '<option value="' . $row['size'] . '"';
                                            echo ($row['size'] == $product["size"]) ? "Selected" : "";
                                            echo ' >' . $row['size'] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>
                                    <?php endif ?>
                                  </form>
                                </td>
                                <td>
                                  <div class="float-left mx-4">
                                    <?php echo "PKR. " . $product["price"]; ?>
                                  </div>
                                  <div class="pl-2 float-right">
                                    <form method='post' action=''>
                                      <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                      <input type='hidden' name='type' value="<?php echo $product["type"]; ?>" />
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
                              $subtotal += ($product["price"] * $product["quantity"]);
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    <?php endif ?>

                    <br>
                    <p class="lead">Amount</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>PKR <?php echo $subtotal ?  $subtotal : "--.--" ?></td>
                        </tr>
                        <tr>
                          <th>Tax (13%)</th>
                          <td>PKR --.--</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>PKR <?php echo $deliverycharges ? $deliverycharges : "--.--" ?></td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <?php if ($subtotal) {
                            $total = $subtotal + $deliverycharges;
                            echo '<script> document.getElementById("totalPrice").value = "' . $total . '"; </script>';
                          } ?>
                          <td>PKR <?php echo $total ?  $total : "--.--" ?></td>
                        </tr>
                      </table>
                      <div class="col-12">
                        <a href="#" rel="noopener" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <button type="button" id="ordersFormButton" class="btn btn-primary float-right" style="margin-right: 5px;">
                          <i class="fas fa-downloa"></i> Confirm
                        </button>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-lg-12">
                    <div class="">
                      <div class="btn-group w-100 mb-2">
                        <a class="btn btn-info active" href="javascript:void(0)" data-filter="all"> All items </a>
                        <a class="btn btn-info " href="javascript:void(0)" data-filter="deals"> Deals </a>
                        <?php
                        while ($row = mysqli_fetch_assoc($categories)) {
                          echo '<a class="btn btn-info" href="javascript:void(0)" data-filter="' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                        }
                        ?>
                      </div>
                      <div class="mb-2">
                        <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>
                      </div>
                    </div>
                    <div class="col-lg-11">
                      <div class="filter-container p-0 mt-3 row">

                        <?php
                        while ($row = mysqli_fetch_assoc($products)) {

                          echo ' <div class="filtr-item col-lg-2 col-md-4" data-category="' . $row['categoryName'] . '">
                                <div class="card card-outline card-info">
                                  <div class="card-header">
                                    <h3 class="card-title text-bold text-sm">' . $row['productName'] . '</h3>
                                  </div>
                                  <div class="card-body">
                                    <div class="text-center" style="">
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['price'] . '</p>
                                    <button class="mt-2 btn btn-info float-right" onclick="addToCart(' . $row['id'] . ')">Add</button>
                                    <select name="product_size" id="product_size_' . $row['id'] . '" class="form-select w-100 border mt-1" aria-label="Default select example">
                                    <option selected disabled>Sizes</option>';
                          include("./includes/restaurants/POS/code.fetchSizesToPOS.php");
                          while ($row = mysqli_fetch_assoc($sizes)) {
                            echo '<option value="' . $row['size'] . '">' . $row['size'] . '</option>';
                          }
                          echo '
                                        </select>
                                      </div>
                                    </div>
                                  </div>';
                        }
                        while ($row = mysqli_fetch_assoc($deals)) {
                          echo '<div class="filtr-item col-lg-2 col-md-4" data-category="deals">
                                <div class="card card-outline card-info">
                                  <div class="card-header">
                                    <h3 class="card-title text-bold text-sm">' . $row['deal_name'] . '</h3>
                                  </div>
                                  <div class="card-body">
                                   <div class="div" style="height: 128px; overflow:hidden;">
                                    <h5>' . $row['deal_desc'] . '</h5>
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['deal_price'] . '</p>
                                  <button class="mt-2 btn btn-info float-right" onclick="addDealToCart(' . $row['id'] . ')">Add</button>
                                  </div>
                                </div>
                              </div>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->

    <script>
      const urlParams = new URLSearchParams(window.location.search);
      const orderID = urlParams.get('orderID');
      const total_price = document.getElementById("totalPrice").value;

      $(function(total_price) {
        $.ajax({
          url: 'orderDetails',
          type: 'POST',
          data: {
            order_product_id: orderID,
            total_price: total_price,
            action: 'updatePrice',
          }
        });
      });

      $(document).ready(function() {
        $("#ordersFormButton").click(function() {
          $("#ordersForm").submit();
        });
      });

      $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
          event.preventDefault();
          $(this).ekkoLightbox({
            alwaysShowClose: true
          });
        });

        $('.filter-container').filterizr({
          gutterPixels: 3
        });
        $('.btn[data-filter]').on('click', function() {
          $('.btn[data-filter]').removeClass('active');
          $(this).addClass('active');
        });
      })

      function addToCart(id) {
        var selectOption = document.getElementById(`product_size_${id}`);
        var product_size = selectOption.options[selectOption.selectedIndex].text;

        if (product_size != null && product_size != 'Sizes') {
          $.ajax({
            url: 'orderDetails',
            type: 'POST',
            data: {
              order_product_id: orderID,
              id: id,
              type: 'product',
              product_size: product_size,
              action: 'addProduct',
            },
          })
        } else {
          Swal.fire('Please Select Size!', "Product size is required", "error");
          exit;
        }
        location.reload();
      }

      function addDealToCart(id) {
        $.ajax({
          url: 'orderDetails',
          type: 'POST',
          data: {
            order_product_id: orderID,
            id: id,
            type: 'deal',
            action: 'addProduct',
          },
        })
        location.reload();
      }

      $(document).ready(function() {
        jQuery('<div class="quantity-nav"><button class="quantity-button quantity-up"><span class="white"><i class="fas fa-angle-up"></i></span></button><button class="quantity-button quantity-down"><span class="white"><i class="fas fa-angle-down"></i></span></button></div>').insertAfter('.quantity input');
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
    </script>
    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>