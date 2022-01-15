<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.updateDeal.php");
include("./includes/restaurants/deals/code.fetchAddons.php");
include("./includes/restaurants/deals/code.fetchCategories.php");


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
            <h3 class="card-title">Update Deal</h3>
          </div>

          <div class="card-body">
            <?php include('./errors.php'); ?>

            <div class="row">
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12">
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                      <div class="col-md-5 mb-3 ">
                        <label for="product_image" class="d-block">Deal Logo</label>
                        <input type="hidden" name="oldImage" value="<?php echo $photo; ?>">
                        <div class="d-flex">
                          <img src="includes/restaurants/deals/deals_imgs/<?php echo $photo; ?>" style="width: 100px;" class="elevation-2" id="product_image" alt="Product Image">
                          <div class="col-md-12 mb-3">
                            <input type="file" class="form-control-file ml-4 mt-4 border rounded p-1" name="newImage" accept='image/*' onchange="readURL(this)" id="newImage">
                            <div class="invalid-feedback">
                              Please select a deal image
                            </div>
                          </div>
                        </div>
                      </div>
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
                          <textarea rows="1" type="text" class="form-control" name="dealDesc" placeholder="Enter deal description" id="description" required><?Php echo $description ?></textarea>
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
                          <button type="submit" class="mt-4 btn btn-primary float-right" style="margin-right: 5px;">Save Changes</button>
                          <?php if ($_SESSION['role'] == 'admin') : ?>
                            <button type="button" onclick="window.history.back()" class="mt-4 btn btn-danger float-right" style="margin-right: 5px;">
                              Go Back
                            </button>
                          <?php endif ?>
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
                              <?php if ($product['type'] == 'product') : ?>
                                <img src='includes/restaurants/products/product_imgs/<?php echo $product['image'] ?>' class='img-fluid img-thumbnail' alt='err'>
                              <?php endif ?>
                              <?php if ($product['type'] == 'addon') : ?>
                                <h2 class="border p-1">A<span style="font-size: 17px;font-weight: bold;">ddon</span></h2>
                              <?php endif ?>
                            </td>
                            <td class="pl-2">
                              <div class="float-left mr-4">
                                <?php echo $product["name"]; ?><br />
                              </div>
                            </td>
                            <td>
                              <form action="" method="post">
                                <input type='hidden' name='deal_products_id' value="<?php echo $product["deal_products_id"]; ?>" />
                                <input type='hidden' name='action' value="change" />
                                <div class="quantity">
                                  <input type="number" name="qty" min="1" step="1" value="<?php echo $product["qty"] ?>" onchange="this.form.submit()">
                                </div>
                                <?php if ($product['type'] == 'product') : ?>
                                  <div class="">
                                    <select name="product_size" onchange="this.form.submit()" class="form-select w-100 border mt-1 mb-2" aria-label="Default select example">
                                      <option selected disabled>Sizes</option>
                                      <?php
                                      include("./includes/restaurants/deals/code.fetchSizes.php");
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
                  <div class="row m-1">
                    <a class="btn btn-info active m-1" href="javascript:void(0)" data-filter="all"> All items </a>
                    <?php
                    while ($row = mysqli_fetch_assoc($categories)) {
                      echo '<a class="btn btn-info m-1" href="javascript:void(0)" data-filter="' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                    }
                    ?>
                    <a class="btn btn-info m-1" href="javascript:void(0)" data-filter="addons">Addons</a>
                  </div>
                </div>
                <div class="mb-2">
                  <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>

                </div>
              </div>
              <div class="col-lg-11">
                <div class="filter-container p-0 mt-3 row">

                  <?php
                  if ($_SESSION['role'] == 'admin') {
                    $branchID = trim($_GET['branchId']);

                    $query = "SELECT products.id, products.name as productName, categories.category_name as categoryName, products.description, products.price, products.photo, products.item_availability, products.active_status, products.created_at, products.updated_at FROM `products` JOIN categories on products.category_id = categories.id WHERE restaurant_id = " . $branchID . " AND products.active_status = 'active'  AND categories.active_status = 'active'";
                  }
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
                                  <div class="card-body">';
                    $query = "SELECT * FROM `sizes` WHERE product_id = " . $row['id'];
                    $sizes = mysqli_query($conn, $query);
                    $nomRows = mysqli_num_rows($sizes);
                    if ($nomRows > 0) {
                      echo '<div class="text-center" style="">
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['price'] . '</p>
                                    <button class="mt-2 btn btn-info float-right" onclick="addProductToDeal(' . $row['id'] . ',' . $dealID . ')">Add</button>';

                      echo '<select name="product_size" id="product_size_' . $row['id'] . '" class="form-select w-100 border mt-1" aria-label="Default select example">
                                    <option selected disabled>Sizes</option>';
                      include("./includes/restaurants/deals/code.fetchSizes.php");
                      while ($row = mysqli_fetch_assoc($sizes)) {
                        if ($row['id'] == $size['product_id']) {
                          echo '<option value="' . $size['id'] . '">' . $size['size'] . ' (' . $size['price'] . ')</option>';
                        }
                      }
                    } else {
                      echo '<div class="text-center"  style="height:128px;" >
                                      <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                                    </div>
                                    <p class="card-text text-bold mt-3 float-left text-sm">PKR. ' . $row['price'] . '</p>
                                    
                                    <button class="mt-2 btn btn-info float-right" onclick="addToDeal_withoutSize(' . $row['id'] . ')">Add</button>';
                    }
                    echo '</select></div></div></div>';
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
                  } ?>
                </div>
              </div>

            </div>
          </div>
        </div>



      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>

  </div>
  <!-- ./wrapper -->


  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function(e) {
          document.querySelector("#product_image").setAttribute("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
      }
    };
    var input = document.getElementById("price");
    var dealPrice = document.getElementById("dealPrice");
    dealPrice.innerHTML = input.value;

    function priceToHeading() {
      var input = document.getElementById("price");
      var dealPrice = document.getElementById("dealPrice");
      dealPrice.innerHTML = input.value;
    }

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

    const urlParams = new URLSearchParams(window.location.search);
    const branchId = urlParams.get('branchId');

    function addProductToDeal(productID, dealID) {
      var selectOption = document.getElementById(`product_size_${productID}`);
      var product_size = selectOption.options[selectOption.selectedIndex].text;

      if (product_size != null && product_size != 'Sizes') {
        $.ajax({
            url: 'addToDeal',
            type: 'POST',
            data: {
              productID: productID,
              dealID: dealID,
              type: 'product',
              product_size: product_size
            },
          })
          .done(function(response) {
            if (response == 1) {
              window.location.href = `update.deals?dealID=${dealID}&branchId=${branchId}`;
            }
            if (response == 0) {
              Swal.fire('Alreay Exist!', "Product already in deal", "error");
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

    function addAddonToDeal(productID, dealID) {
      $.ajax({
          url: 'addToDeal',
          type: 'POST',
          data: {
            productID: productID,
            dealID: dealID,
            type: 'addon',
          },
        })
        .done(function(response) {
          if (response == 1) {
            window.location.href = `update.deals?dealID=${dealID}&branchId=${branchId}`;
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


</body>

</html>