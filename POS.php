<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/categories/code.fetchCategories.php");


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

                  <div class="col-lg-9">
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
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="customername">Customer's Name</label>
                            <input type="text" class="form-control" name="customerName" id="customername" placeholder="Name">
                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="customerPhone">Customer's Phone</label>
                            <input type="number" name="customerPhone" class="form-control" id="customerPhone" placeholder="Phone">
                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="customerEmail">Customer's Email</label>
                            <input type="email" name="customerEmail" class="form-control" id="customerEmail" placeholder="Email">
                          </div>
                        </div>

                      </div>
                    </form>

                  </div>

                  <div class="col-lg-3 mb-4">
                    <h2 class="">Cart</h2>

                    <div class=" text-center my-4">
                      <i class="text-black-50 fas fa-cart-plus" style="font-size:20px"></i>
                      <p>
                        Your cart is empty <br>
                        Add product to get started </p>
                    </div>

                    <br>
                    <p class="lead">Amount</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>PKR --.--</td>
                        </tr>
                        <tr>
                          <th>Tax (13%)</th>
                          <td>PKR --.--</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>PKR --.--</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>PKR --.--</td>
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
                  <div class="col-lg-9">

                    <div class="">
                      <div class="btn-group w-100 mb-2">
                        <a class="btn btn-info active" href="javascript:void(0)" data-filter="all"> All items </a>
                        <?php
                        while ($row = mysqli_fetch_assoc($results)) {
                          echo '<a class="btn btn-info" href="javascript:void(0)" data-filter="' . $row["category_name"] . '">' . $row["category_name"] . '</a>';
                        }
                        ?>
                      </div>
                      <div class="mb-2">
                        <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>
                      </div>
                    </div>
                    <div class="">
                      <div class="filter-container p-0 mt-3 row">

                        <?php
                        include("./includes/restaurants/products/code.fetchProducts.php");
                        while ($row = mysqli_fetch_assoc($results)) {
                          echo ' <div class="filtr-item col-lg-2 col-md-4" data-category="' . $row['categoryName'] . '">
                      <div class="card card-outline card-info">
                        <div class="card-header">
                          <h3 class="card-title text-bold text-sm">' . $row['productName'] . '</h3>
                        </div>
                        <div class="card-body">
                          <div class="text-center" style="">
                            <img class="img-flui" style="width: 100px; height: 100px;" src="includes/restaurants/products/product_imgs/' . $row['photo'] . '">
                          </div>
                          <p class="card-text text-bold mt-3 text-sm">PKR. ' . $row['price'] . '</p>
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
    </script>
    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>