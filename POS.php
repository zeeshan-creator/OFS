<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/orders/code.saveOrders.php");

include("./includes/restaurants/POS/code.fetchCategoriesToPOS.php");
include("./includes/restaurants/POS/code.fetchProductsToPOS.php");
include("./includes/restaurants/POS/code.fetchAddonsToPOS.php");
include("./includes/restaurants/POS/code.fetchDealsToPOS.php");
include("./includes/restaurants/POS/code.fetchOffersToPOS.php");
include("./includes/restaurants/POS/code.pos.php");

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

  #add_toast,
  #Remove_toast {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
  }

  #add_toast.show,
  #Remove_toast.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
  }

  @-webkit-keyframes fadein {
    from {
      bottom: 0;
      opacity: 0;
    }

    to {
      bottom: 30px;
      opacity: 1;
    }
  }

  @keyframes fadein {
    from {
      bottom: 0;
      opacity: 0;
    }

    to {
      bottom: 30px;
      opacity: 1;
    }
  }

  @-webkit-keyframes fadeout {
    from {
      bottom: 30px;
      opacity: 1;
    }

    to {
      bottom: 0;
      opacity: 0;
    }
  }

  @keyframes fadeout {
    from {
      bottom: 30px;
      opacity: 1;
    }

    to {
      bottom: 0;
      opacity: 0;
    }
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

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
                <h4 class="card-title">POS Orders</h4>
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
                                  <input type="hidden" name="action" value="saveOrder">
                                  <input type="radio" name="orderType" value="Pick_Up" id="img2" class="d-none imgbgchk form-check-input" required checked="checked">
                                  <label for="img2" class="form-check-label" for="img2">
                                    <img class="img-fluid mb-1 rounded" src="includes\restaurants\POS\order_type_icons/pngtree-catering-takeaway-icon-image_2245469.jpg" alt="Image 2">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Pick Up
                                  </label>
                                </div>
                                <div class='col form-check text-center '>
                                  <input type="radio" name="orderType" value="Delivery" id="img1" class="d-none imgbgchk form-check-input" required>
                                  <label for="img1" class="form-check-label" for="img1">
                                    <img class="img-fluid mb-1 rounded" src="includes\restaurants\POS\order_type_icons/pngtree-delivery-boy-with-mask-riding-bike-vector-png-image_2187935.jpg" alt="Image 1">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Delivery
                                  </label>
                                </div>
                                <div class='col form-check text-center'>
                                  <input type="radio" name="orderType" value="Dine_In" id="img3" class="d-none imgbgchk form-check-input" required>
                                  <label for="img3" class="form-check-label" for="img3">
                                    <img class="img-fluid mb-1 rounded" src="includes\restaurants\POS\order_type_icons/pngtree-vegetable-salad-food-vegetables-vegetable-salad-food-pattern-png-image_388734.jpg" alt="Image 3">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Dine In
                                  </label>
                                </div>
                                <div class='col form-check text-center'>
                                  <input type="radio" name="orderType" value="Drive_Thru" id="img4" class="d-none imgbgchk form-check-input" required>
                                  <label for="img4" class="form-check-label" for="img4">
                                    <img class="img-fluid mb-1 rounded" src="includes\restaurants\POS\order_type_icons/pngtree-drive-in-movie-signage-png-image_1993590.jpg" alt="Image 4">
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
                            <input type="text" class="form-control" name="customerName" id="customername" placeholder="Name">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="customerPhone">Customer's Phone <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="number" name="customerPhone" class="form-control" id="customerPhone" placeholder="Phone">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="customerEmail">Customer's Email <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="email" name="customerEmail" class="form-control" id="customerEmail" placeholder="Email">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label for="orderNote">Special instructions <span style="font-weight: lighter;">(Optional)</span> </label>
                            <input type="text" name="orderNote" class="form-control" id="orderNote" placeholder="Order Note">
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>

                  <div class="col-lg-4 mb-4">
                    <div class="" id="item_cart">

                      <h2 class="">Item/s
                        <?php
                        if (!empty($_SESSION["shopping_cart"])) {
                          $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                        ?>
                          : <span><?php echo $cart_count; ?></span>
                        <?php
                        }
                        ?>
                      </h2>

                      <?php if (empty($_SESSION["shopping_cart"])) : ?>
                        <div class="text-center my-4">
                          <i class="text-black-50 fas fa-cart-plus" style="font-size:20px"></i>
                          <p>
                            Your cart is empty <br>
                            Add product to get started </p>
                        </div>
                      <?php endif ?>

                      <?php if (!empty($_SESSION["shopping_cart"])) : ?>
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
                            <?php foreach ($_SESSION["shopping_cart"] as $product) {
                            ?>
                              <tr>
                                <td style='width:60px;height:50px' class="text-center">
                                  <?php if ($product['type'] == 'product') : ?>
                                    <img src='includes/restaurants/products/product_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                                  <?php endif ?>
                                  <?php if ($product['type'] == 'deal') : ?>
                                    <img src='includes/restaurants/deals/deals_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                                  <?php endif ?>
                                  <?php if ($product['type'] == 'addon') : ?>
                                    <img src='includes/restaurants/addon_products/addons_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                                  <?php endif ?>
                                </td>
                                <td class="pl-2">
                                  <div class="float-left mr-4">
                                    <?php echo $product["name"]; ?><br />
                                  </div>
                                </td>
                                <td>
                                  <div class="quantity mt-2">
                                    <input type="number" name="quantity" min="1" step="1" value="<?php echo $product["quantity"] ?>" onchange="changeQty('<?php echo $product['id']; ?>',this.value)">
                                  </div>

                                  <?php if ($product['type'] == 'product' && $product['size'] != null) : ?>
                                    <div class="">
                                      <select name="product_size" class="form-select w-100 border mt-1 mb-2" aria-label="Default select example">
                                        <?php
                                        $query = "SELECT * FROM `sizes` WHERE id = " . $product["size"];
                                        $sizes = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($sizes);
                                        echo "<option selected disabled>" . $row['size'] . "</option>";

                                        ?>
                                      </select>
                                    </div>
                                  <?php endif ?>
                                </td>
                                <td>
                                  <div class="float-left mx-4">
                                    <?php echo "PKR. " . $product["price"]; ?>
                                  </div>
                                  <div class="pl-2 float-right">
                                    <button type='button' onclick="removeFromCart('<?php echo $product['id']; ?>')" class='remove btn btn-danger'>
                                      <span style='color:white;'>
                                        <i class='fas fa-trash-alt'></i>
                                      </span>
                                    </button>
                                  </div>
                                </td>
                              </tr>
                            <?php
                              $subtotal += ($product["price"] * $product["quantity"]);
                            }
                            ?>
                          </tbody>
                        </table>
                      <?php endif ?>

                    </div>

                    <br>
                    <p class="lead">Amount</p>

                    <div class="table-responsive">
                      <table class="table" id="prices">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>PKR <?php echo $subtotal ?  $subtotal : "--.--" ?></td>
                        </tr>

                        <tr>
                          <th>Discount:</th>
                          <?php if ($subtotal >= $ordersOver) {
                            $offerDiscount = round($subtotal / 100 * $offerPercentage);
                          }
                          ?>
                          <td>PKR <?php echo $offerDiscount ? $offerDiscount : "--.--" ?></td>
                        </tr>

                        <?php if ($offerDiscount != null) : ?>
                          <h4><?php echo $offer['offer_name'] ?></h4>
                          <p><?php echo $offer['offer_percentage'] ?>% discount on orders over <?php echo $offer['order_over'] ?> </p>
                        <?php endif ?>

                        <tr>
                          <th>Total:</th>
                          <?php if ($subtotal) {
                            $total = $subtotal - $offerDiscount;
                            echo '<script> document.getElementById("totalPrice").value = "' . $total . '"; </script>';
                          }
                          ?>
                          <td>PKR <?php echo $total ?  $total : "--.--" ?></td>
                        </tr>
                      </table>
                      <div class="col-12">
                        <a href="billPrint" rel="noopener" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <button type="button" id="ordersFormButton" class="btn btn-primary float-right" style="margin-right: 5px;">
                          Confirm
                        </button>
                      </div>
                    </div>

                  </div>

                </div>
              </div>

              <hr>
              <div class="row">
                <div class="col-lg-12">
                  <div class="">
                    <div class="btn-group w-100 mb-2">
                      <div class="row ml-1">
                        <a class="btn btn-info active pb-0" href="javascript:void(0)" data-filter="all"> All items</a>
                        <a class="btn btn-info m-1" href="javascript:void(0)" data-filter="deals"> Deals </a>
                        <?php
                        while ($row = mysqli_fetch_assoc($categories)) {
                          echo '<a class="btn btn-info m-1" data-filter="' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                        }
                        ?>
                        <a class="btn btn-info m-1" href="javascript:void(0)" data-filter="addons">Addons</a>
                      </div>
                    </div>
                    <div class="mb-2 ml-1">
                      <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>
                    </div>
                  </div>
                  <div class="col-lg-11 ml-1">
                    <div class="filter-container p-0 mt-3 row">

                      <?php
                      while ($row = mysqli_fetch_assoc($products)) {

                        echo ' <div class="filtr-item col-lg-2 col-md-4" data-category="' . $row['categoryName'] . '">
                                <div class="card card-outline card-info">
                                  <div class="card-header">
                                    <h3 class="card-title text-bold text-sm">' . $row['productName'] . '</h3>
                                  </div>
                                  <div class="card-body">';
                        $query = "SELECT * FROM `sizes` WHERE product_id = " . $row['id'];
                        $sizes = mysqli_query($conn, $query);
                        $nomRows = mysqli_num_rows($sizes);
                        if ($nomRows > 0) {
                          echo '<div class="text-center" id="">
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                                    </div>
                                    <button class="mt-2 btn btn-info float-right" onclick="addToCart(' . $row['id'] . ')">Add</button>';

                          echo '<select name="product_size" id="product_size_' . $row['id'] . '" class="form-select w-100 border mt-1" aria-label="Default select example">
                          <option selected disabled>Sizes </option>
                                    ';
                          while ($size = mysqli_fetch_assoc($sizes)) {
                            if ($row['id'] == $size['product_id']) {
                              echo '<option value="' . $size['id'] . '">' . $size['size'] . ' (' . $size['price'] . ')</option>';
                            }
                          }
                        } else {
                          echo '<div class="text-center"  style="height:128px;" >
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['price'] . '</p>
                                    
                                    <button class="mt-2 btn btn-info float-right" onclick="addToCart_withoutSize(' . $row['id'] . ')">Add</button>';
                        }
                        echo '</select></div></div></div>';
                      }

                      while ($row = mysqli_fetch_assoc($deals)) {
                        echo '<div class="filtr-item col-lg-2 col-md-4" data-category="deals">
                                <div class="card card-outline card-info">
                                  <div class="card-header">
                                    <h3 class="card-title text-bold text-sm">' . $row['deal_name'] . '</h3>
                                  </div>
                                  <div class="card-body">
                                   <div class="text-center" style="height:128px;">
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/deals/deals_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['deal_price'] . '</p>
                                  <button class="mt-2 btn btn-info float-right" onclick="addDealToCart(' . $row['id'] . ')">Add</button>
                                  </div>
                                </div>
                              </div>';
                      }

                      while ($row = mysqli_fetch_assoc($addons)) {
                        echo '<div class="filtr-item col-lg-2 col-md-4" data-category="addons">
                                <div class="card card-outline card-info">
                                  <div class="card-header">
                                    <h3 class="card-title text-bold text-sm">' . $row['name'] . '</h3>
                                  </div>
                                  <div class="card-body">
                                   <div class="text-center" style="height:128px;">
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/addon_products/addons_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['price'] . '</p>
                                  <button class="mt-2 btn btn-info float-right" onclick="addAddonToCart(' . $row['id'] . ')">Add</button>
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
  <div id="add_toast">Product Added To Cart</div>
  <div id="Remove_toast">Removed From Cart</div>
  <!-- Including footer -->
  <?php include './partials/footer.php' ?>
  <?php ob_end_flush(); ?>
  <script>
    $(document).ready(function() {
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
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

    function removeFromCart(id) {
      $.ajax({
          url: 'POS',
          type: 'POST',
          data: {
            key: id,
            action: 'remove'
          },
        })
        .done(function(response) {
          $("#item_cart").load(window.location.href + " #item_cart");
          $("#prices").load(window.location.href + " #prices");
          Remove_toast();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong! Please try again', 'error');
        });
    }

    function changeQty(id, quantity) {
      $.ajax({
          url: 'POS',
          type: 'POST',
          data: {
            id: id,
            action: 'changeQty',
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

    function addToCart_withoutSize(id) {
      $.ajax({
          url: 'addToCart',
          type: 'POST',
          data: {
            productID: id,
          },
        })
        .done(function(response) {
            $("#item_cart").load(window.location.href + " #item_cart");
            $("#prices").load(window.location.href + " #prices");
            add_toast();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function addToCart(id) {
      var selectOption = document.getElementById(`product_size_${id}`);
      var product_size = selectOption.options[selectOption.selectedIndex].value;
      if (product_size != null && product_size != 'Sizes') {
        $.ajax({
            url: 'addToCart',
            type: 'POST',
            data: {
              productID: id,
              product_size: product_size
            },
          })
          .done(function(response) {
            if (response == 1) {
              $("#item_cart").load(window.location.href + " #item_cart");
              $("#prices").load(window.location.href + " #prices");
              add_toast();
            } else {
              Swal.fire('Alreay Exist!', "Product already in cart", "error");
            }
          })
          .fail(function() {
            swal('Oops...', 'Something went wrong!', 'error');
          });
      } else {
        Swal.fire('Please Select Size!', "Product size is required", "error");
        exit;
      }
    }

    function addDealToCart(id) {
      $.ajax({
          url: 'addToCart',
          type: 'POST',
          data: {
            dealID: id
          },
        })
        .done(function(response) {
          if (response == 1) {
            $("#item_cart").load(window.location.href + " #item_cart");
            $("#prices").load(window.location.href + " #prices");
            add_toast();
          }
          if (response == 0) {
            Swal.fire('Alreay Exist!', "Deal already in cart", "error");
          }
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function addAddonToCart(id) {
      $.ajax({
          url: 'addToCart',
          type: 'POST',
          data: {
            addonID: id
          },
        })
        .done(function(response) {
          if (response == 1) {
            $("#item_cart").load(window.location.href + " #item_cart");
            $("#prices").load(window.location.href + " #prices");
            add_toast();
          }
          if (response == 0) {
            Swal.fire('Alreay Exist!', "Addon Product already in cart", "error");
          }
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
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

    function add_toast() {
      var x = document.getElementById("add_toast");
      x.className = "show";
      setTimeout(function() {
        x.className = x.className.replace("show", "");
      }, 3000);
    }

    function Remove_toast() {
      var x = document.getElementById("Remove_toast");
      x.className = "show";
      setTimeout(function() {
        x.className = x.className.replace("show", "");
      }, 3000);
    }
  </script>

  </div>
  <!-- ./wrapper -->

</body>

</html>