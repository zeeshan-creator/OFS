<?php

include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.updateDeal.php");

if (!isset($_GET['dealID'])) {
  echo '<script>window.location.href = "deals";</script>';
  exit();
}

if (isset($_GET['dealID'])) {
  $dealID = trim($_GET['dealID']);

  $deal_products_query = "SELECT * FROM `deal_products` WHERE deal_id = $dealID";
  $deal_products_result = mysqli_query($conn, $deal_products_query);
  $rows = mysqli_fetch_assoc($deal_products_result);
  $numOfRows = mysqli_num_rows($deal_products_result);


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

          <form method="POST" class="needs-validation" novalidate>
            <div class="card-body">
              <?php include('./errors.php'); ?>

              <div class="row">
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-12">

                      <div class="form-row">
                        <div class=" col-lg-6 mb-3">
                          <input type="hidden" name="dealID" value="<?Php echo $dealID   ?>">
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
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
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
                        Your Deal is empty <br>
                        Add products to make a happy meal </p>
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
                            <td class="pl-4">PKR</td>
                          </tr>
                        </thead>
                        <tbody>

                          <?php foreach ($_SESSION["Deal_items"] as $product) {
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
                        <th style="width:50%">Products total:</th>
                        <td>PKR <?php echo $subtotal ?  $subtotal : "--.--" ?></td>
                      </tr>
                      <tr>
                        <th>Deal Price:</th>
                        <td>PKR <span id="dealPrice"></span></td>
                      </tr>
                    </table>
                    <div class="col-12">
                      <button class="btn btn-danger mr-3" type="button" onclick="window.history.back()">Discard</button>
                      <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-downloa"></i> Save Changes
                      </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </form>

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
                  Swal.fire('Added!', "Product Added", "success");
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
        </script>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>