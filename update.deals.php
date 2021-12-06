<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.updateDeal.php");

if (!isset($_GET['dealID'])) {
  echo '<script>window.location.href = "deals";</script>';
  exit();
}

$_SESSION['deal_products'] = array();

if (isset($_POST['action']) && $_POST['action'] == "remove") {
  $product_id = trim($_POST['id']);
  $products_query  = 'DELETE FROM `deal_products` WHERE `product_id` =' . $product_id;
  mysqli_query($conn, $products_query);
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
  $product_qty = trim($_POST['qty']);
  $product_id = trim($_POST['id']);
  $products_query  = 'UPDATE `deal_products` SET `qty`= ' . $product_qty . ' WHERE `product_id` =' . $product_id;
  mysqli_query($conn, $products_query);
}

if (isset($_GET['dealID'])) {
  $dealID = trim($_GET['dealID']);

  $deal_products_query = "SELECT `product_id` FROM `deal_products` WHERE `deal_id` = $dealID";
  $deal_products_result = mysqli_query($conn, $deal_products_query);

  while ($rows = mysqli_fetch_assoc($deal_products_result)) {
    $products_query  = 'SELECT `id`, `name`, `price`, `photo` FROM `products` where `id` =' . $rows['product_id'];
    $products_result = mysqli_query($conn, $products_query);
    $row = mysqli_fetch_assoc($products_result);

    $products_qty_query  = 'SELECT `qty` FROM `deal_products` where `product_id` =' . $rows['product_id'];
    $products_qty_result = mysqli_query($conn, $products_qty_query);
    $qty = mysqli_fetch_assoc($products_qty_result);

    $id = $row['id'];
    $name = $row['name'];
    $price = $row['price'];
    $qty = $qty['qty'];
    $image = $row['photo'];

    $dealProducts = array(
      $name => array(
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'qty' => $qty,
        'image' => $image
      )
    );
    $_SESSION['deal_products'] = array_merge($_SESSION['deal_products'], $dealProducts);
  }


  $deal_query = "SELECT * FROM deals WHERE id='$dealID' LIMIT 1";
  $result = mysqli_query($conn, $deal_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $name = $row["deal_name"];
    $price = $row["deal_price"];
    $description = $row["deal_desc"];
    $active_status = $row["active_status"];
  } else {
    echo '<script>window.location.href = "deals";</script>';
    exit();
  }
}



ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>

<style>
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
    <div class="content-wrapper">

      <div class="row m-1">
        <div class="card card-info w-100 p-2">
          <div class="card-header">
            <h3 class="card-title">Create Deal</h3>
          </div>

          <div class="card-body">
            <?php include('./errors.php'); ?>

            <div class="row">
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12">
                    <form method="POST" class="needs-validation" novalidate>
                      <div class="form-row">
                        <div class=" col-lg-6 mb-3">
                          <input type="hidden" name="dealID" value="<?Php echo $dealID   ?>">
                          <input type="hidden" name="action" value="update">
                          <label for="dealName">Deal name</label>
                          <input type="text" class="form-control" value="<?Php echo $name ?>" name="dealName" min="3" max="15" placeholder="Enter deal Name" id="dealName" required>
                          <div class="invalid-feedback">
                            Please enter a deal name
                          </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="price">price</label>
                          <input type="number" class="form-control" value="<?Php echo $price ?>" name="dealPrice" placeholder="Enter deal price" id="price" required onkeyup="priceToHeading()">
                          <div class="invalid-feedback">
                            Please enter a deal price
                          </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                          <label for="description">Deal description</label>
                          <textarea type="text" class="form-control" name="dealDesc" placeholder="Enter deal description" id="description" required><?Php echo $description ?></textarea>
                          <div class="invalid-feedback">
                            Please enter a deal description
                          </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="activeStatus">Active Status</label>
                          <select class="form-control" id="activeStatus" name="active_status" required>
                            <?php
                            if ($active_status == "active") {
                              echo '<option value="active" selected>Active</option>
                                          <option value="inactive">Inactive</option>';
                            }
                            if ($active_status == "inactive") {
                              echo '<option value="inactive" selected>Inactive</option>
                                       <option value="active">Active</option>';
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">
                            Please enter a active status
                          </div>
                        </div>
                        <div class="col-lg-12 mt-4">
                          <button type="submit" class="mt-4 btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-downloa"></i> Save Changes
                          </button>
                          <button class="mt-4 btn btn-danger mr-3 float-right" type="button" onclick="window.history.back()">Discard</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <h2 class="">Item/s
                  <?php
                  if (!empty($_SESSION['deal_products'])) {
                    $product_count = count(array_keys($_SESSION['deal_products']));
                  ?>
                    : <span><?php echo $product_count; ?></span>
                  <?php
                  }
                  ?>
                </h2>

                <?php if (empty($_SESSION['deal_products'])) : ?>
                  <div class="text-center my-4">
                    <i class="text-black-50 fas fa-cart-plus" style="font-size:20px"></i>
                    <p>
                      Your Deal is empty <br>
                      Add products to make a happy meal </p>
                  </div>
                <?php endif ?>

                <?php $subtotal = 0; ?>
                <?php if (!empty($_SESSION['deal_products'])) : ?>
                  <div class="">
                    <table>
                      <thead>
                        <tr class="text-bold">
                          <td></td>
                          <td class="pl-3">ITEM</td>
                          <td class="pl-4">QTY</td>
                          <td class="pl-5">PKR</td>
                        </tr>
                      </thead>
                      <tbody>

                        <?php foreach ($_SESSION['deal_products'] as $product) {
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
                              <form action="" method="post">
                                <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                <input type='hidden' name='action' value="change" />
                                <div class="quantity">
                                  <input type="number" name="qty" min="1" step="1" value="<?php echo $product["qty"] ?>" onchange="this.form.submit()">
                                </div>
                              </form>
                            </td>
                            <td>
                              <div class="float-left mx-4">
                                <?php echo "PKR. " . $product["price"]; ?>
                              </div>
                              <div class="pl-2 float-right">
                                <form method='post' action=''>
                                  <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
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
                          $subtotal += ($product["price"] * $product["qty"]);
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
                      <th style="width:50%">Products total:</th>
                      <td>PKR <?php echo $subtotal ?  $subtotal : "--.--" ?></td>
                    </tr>
                    <tr>
                      <th>Deal Price:</th>
                      <td>PKR <span id="dealPrice"></span></td>
                    </tr>
                  </table>
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
                            <button type="button" onclick="addToDeal(' . $row['id'] . ',' . $dealID . ')" class="btn btn-info float-right mt-2">
                              Add</button>
                        </div>
                      </div>
                    </div>';
                  } ?>
                </div>
              </div>


            </div>
          </div>
        </div>


        <script>
          var input = document.getElementById("price");
          var dealPrice = document.getElementById("dealPrice");
          dealPrice.innerHTML = input.value;

          function priceToHeading() {
            var input = document.getElementById("price");
            var dealPrice = document.getElementById("dealPrice");
            dealPrice.innerHTML = input.value;
          }
          // $(document).ready(function() {
          //   $("button").click(function() {
          //     $("p").html("Hello <b>world!</b>");
          //   });
          // });
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

          function addToDeal(productID, dealID) {
            $.ajax({
                url: 'addToDeal',
                type: 'POST',
                data: {
                  productID: productID,
                  dealID: dealID
                },
              })
              .done(function(response) {
                if (response == 1) {
                  location.reload();
                }
                if (response == 0) {
                  Swal.fire('Alreay Exist!', "Product already in deal", "error");
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
        </script>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>