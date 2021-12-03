<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';

if (isset($_POST['action']) && $_POST['action'] == "remove") {
  if (!empty($_SESSION["shopping_cart"])) {
    foreach ($_SESSION["shopping_cart"] as $id => $value) {
      if ($_POST["key"] == $id) {
        unset($_SESSION["shopping_cart"][$id]);
        $status = "Product is removed from your cart";
        echo "<script>window.location.href = 'pos';</script>";
        // echo 2;
      }
      if (empty($_SESSION["shopping_cart"])) {
        unset($_SESSION["shopping_cart"]);
        echo "<script>window.location.href = 'pos';</script>";
      }
    }
  }
}


if (isset($_POST['action']) && $_POST['action'] == "change") {
  foreach ($_SESSION["shopping_cart"] as &$value) {
    if ($value['id'] === $_POST["id"]) {
      $value['quantity'] = $_POST["quantity"];
      break; // Stop the loop after we've found the product
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>
<style>
  .imgbgchk:checked+label>.tick_container {
    opacity: 1;
  }

  /*         aNIMATION */
  .imgbgchk:checked+label>img {
    transform: scale(1.25);
    opacity: 0.3;
  }

  .tick_container {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
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
                <h4 class="card-title">POS Orders</h4>
              </div>
              <div class="card-body">
                <div class="row">

                  <div class="col-lg-8">
                    <form action="">

                      <div class="row">
                        <div class="col-lg-12 mb-4">
                          <!-- radio -->
                          <h2>Order Type</h2>

                          <div class="col-lg-6">
                            <div class="container parent">
                              <div class="row">
                                <div class='col text-center'>
                                  <input type="radio" name="imgbackground" id="img1" class="d-none imgbgchk" value="">
                                  <label for="img1">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-vector/20200417/ourlarge/pngtree-delivery-boy-with-mask-riding-bike-vector-png-image_2187935.jpg" alt="Image 1">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Delivery
                                  </label>
                                </div>
                                <div class='col text-center'>
                                  <input type="radio" name="imgbackground" id="img2" class="d-none imgbgchk" value="">
                                  <label for="img2">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/element_our/20200610/ourlarge/pngtree-catering-takeaway-icon-image_2245469.jpg" alt="Image 2">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Pick Up
                                  </label>
                                </div>
                                <div class='col text-center'>
                                  <input type="radio" name="imgbackground" id="img3" class="d-none imgbgchk" value="">
                                  <label for="img3">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-vector/20190116/ourlarge/pngtree-vegetable-salad-food-vegetables-vegetable-salad-food-pattern-png-image_388734.jpg" alt="Image 3">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Dine In
                                  </label>
                                </div>
                                <div class='col text-center'>
                                  <input type="radio" name="imgbackground" id="img4" class="d-none imgbgchk" value="">
                                  <label for="img4">
                                    <img class="img-fluid mb-1 rounded" src="https://png.pngtree.com/png-clipart/20191119/ourlarge/pngtree-drive-in-movie-signage-png-image_1993590.jpg" alt="Image 4">
                                    <div class="tick_container">
                                      <div class="tick"><i class="fa fa-check"></i></div>
                                    </div>
                                    Drive Thru
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <h2>Customer Details</h2>
                      <div class="col-lg-12">

                      </div>
                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="customername">Customer's Name</label>
                            <input type="text" class="form-control" name="customerName" id="customername" placeholder="Name">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="customerPhone">Customer's Phone</label>
                            <input type="number" name="customerPhone" class="form-control" id="customerPhone" placeholder="Phone">
                          </div>
                        </div>
                      </div>

                      <div class="row ml-1 mt-1">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="customerEmail">Customer's Email</label>
                            <input type="email" name="customerEmail" class="form-control" id="customerEmail" placeholder="Email">
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>

                  <div class="col-lg-4 mb-4">
                    <h2 class="">Cart
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

                    <?php $subtotal = 0; ?>
                    <?php if (!empty($_SESSION["shopping_cart"])) : ?>
                      <div class="">
                        <table>
                          <thead>
                            <tr class="text-bold">
                              <td></td>
                              <td class="pl-2">ITEM</td>
                              <td class="">QTY</td>
                              <td class="pl-4">PKR</td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($_SESSION["shopping_cart"] as $product) {
                            ?>
                              <tr>
                                <td style='width:60px;height:50px' class="">
                                  <img src='includes/restaurants/products/product_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                                </td>
                                <td class="pl-2">
                                  <div class="float-left mr-4">
                                    <?php echo $product["name"]; ?><br />
                                  </div>
                                </td>
                                <td>
                                  <form method='post' action=''>
                                    <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                    <input type='hidden' name='action' value="change" />
                                    <select name='quantity' class='quantity' onchange="this.form.submit()">
                                      <option <?php if ($product["quantity"] == 1) echo "selected"; ?> value="1">1</option>
                                      <option <?php if ($product["quantity"] == 2) echo "selected"; ?> value="2">2</option>
                                      <option <?php if ($product["quantity"] == 3) echo "selected"; ?> value="3">3</option>
                                      <option <?php if ($product["quantity"] == 4) echo "selected"; ?> value="4">4</option>
                                      <option <?php if ($product["quantity"] == 5) echo "selected"; ?> value="5">5</option>
                                      <?php if ($product["quantity"] > 5) : ?>
                                        <option <?php if ($product["quantity"]) echo "selected"; ?> value="<?php echo $product["quantity"]; ?>"><?php echo $product["quantity"]; ?></option>
                                      <?php endif ?>
                                    </select>
                                  </form>
                                </td>
                                <td>
                                  <div class="float-left mx-4">
                                    <?php echo "PKR. " . $product["price"]; ?>
                                  </div>
                                  <div class="pl-2 float-right">
                                    <form method='post' action=''>
                                      <input type='hidden' name='key' value="<?php echo $product["name"]; ?>" />
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
                          <td>PKR 150</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>PKR <?php echo $subtotal ?  $subtotal + 150 : "--.--" ?></td>
                        </tr>
                      </table>
                      <div class="col-12">
                        <a href="#" rel="noopener" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
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
                        <?php
                        if ($_SESSION['role'] == 'main_branch') {
                          $query = "SELECT categories.id, categories.category_name, categories.category_desc, categories.created_at, restaurants.name AS mainBranchName FROM `categories` JOIN restaurants on categories.restaurant_id = restaurants.id WHERE restaurants.id = " . $_SESSION['id'] . " AND categories.active_status = 'active'";
                        }

                        if ($_SESSION['role'] == 'sub_branch') {
                          $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
                          $results = mysqli_query($conn, $query);
                          $row = mysqli_fetch_assoc($results);

                          $query = "SELECT categories.id, categories.category_name, categories.category_desc, categories.created_at, restaurants.name AS mainBranchName FROM `categories` JOIN restaurants on categories.restaurant_id = restaurants.id WHERE restaurants.id = " . $row['main_branch'] . " AND categories.active_status = 'active'";
                        }
                        $categories = mysqli_query($conn, $query);
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
                        if ($_SESSION['role'] == 'main_branch') {
                          $query = "SELECT products.id, products.name as productName, categories.category_name as categoryName, products.description, products.price, products.photo, products.item_availability, products.active_status, products.created_at, products.updated_at FROM `products` JOIN categories on products.category_id = categories.id WHERE restaurant_id = " . $_SESSION['id'] . " AND products.active_status = 'active'  AND categories.active_status = 'active'";
                        }

                        if ($_SESSION['role'] == 'sub_branch') {
                          $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
                          $results = mysqli_query($conn, $query);
                          $row = mysqli_fetch_assoc($results);

                          $query = "SELECT products.id, products.name as productName, categories.category_name as categoryName, products.description, products.price, products.photo, products.active_status FROM `products` JOIN categories on products.category_id = categories.id WHERE restaurant_id = " . $row['main_branch'] . " AND products.active_status = 'active'  AND categories.active_status = 'active'";
                        }
                        $products = mysqli_query($conn, $query);
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
                        <button class="mt-1 btn btn-info float-right" onclick="addToCart(' . $row['id'] . ')">Add</button>
                        </div>
                      </div>
                    </div>';
                        } ?>
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
        $.ajax({
            url: 'addToCart',
            type: 'POST',
            data: {
              productID: id
            },
          })
          .done(function(response) {
            if (response == 1) {
              Swal.fire('Added!', "Product Added", "success");
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
    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>