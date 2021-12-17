<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/offers/code.updateOffer.php");

if (!isset($_GET['offerID'])) {
  echo '<script>window.location.href = "offers";</script>';
  exit();
}

if (isset($_GET['offerID'])) {
  $offerID = trim($_GET['offerID']);

  $product_query = "SELECT * FROM offers WHERE id='$offerID' LIMIT 1";
  $result = mysqli_query($conn, $product_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $offer_name = $row['offer_name'];
    $offer_percentage = $row['offer_percentage'];
    $offer_message = $row['offer_message'];
    $order_over = $row['order_over'];
    $valid_from = $row['valid_from'];
    $valid_till = $row['valid_till'];
    $active_status = $row["active_status"];
  } else {
    echo '<script>window.location.href = "offers";</script>';
    exit();
  }
}
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
            <h3 class="card-title">Create Offer</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <div class="row">
              <div class="col-lg-12">

                <form method="POST" class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class=" col-lg-6 mb-3">
                      <label for="offer_name">Offer Name</label>
                      <input type="hidden" name="offerID" value="<?php echo $offerID; ?>">
                      <input type="text" class="form-control" value="<?php echo $offer_name; ?>" name="offer_name" min="3" max="15" placeholder="Enter offer name" id="offer_name" required>
                      <div class="invalid-feedback">
                        Please enter a offer name
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="offer_percentage">Offer Percentage</label>
                      <input type="number" class="form-control" value="<?php echo $offer_percentage; ?>" name="offer_percentage" placeholder="Enter offer offer percentage" id="offer_percentage" required>
                      <div class="invalid-feedback">
                        Please enter a offer percentage
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="offer_message">Offer Message</label>
                      <textarea rows="1" type="text" class="form-control" name="offer_message" placeholder="Enter offer offer message" id="offer_message" required><?php echo $offer_message; ?></textarea>
                      <div class="invalid-feedback">
                        Please enter a offer message
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="order_over">On Orders Over (<span style="font-weight: lighter;"> optional, default is 0</span>)</label>
                      <input type="number" class="form-control" value="<?php echo $order_over; ?>" name="order_over" placeholder="Enter offer price" id="order_over">
                      <div class="invalid-feedback">
                        Please enter a price
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="valid_from">Offer From</label>
                      <input type="date" class="form-control" value="<?php echo $valid_from; ?>" name="valid_from" placeholder="Enter offer start date" id="valid_from" required>
                      <div class="invalid-feedback">
                        Please enter a offer start date
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="valid_till">Offer Till</label>
                      <input type="date" class="form-control" value="<?php echo $valid_till; ?>" name="valid_till" placeholder="Enter offer end date" id="valid_till" required disabled>
                      <div class="invalid-feedback">
                        Please enter a offer end date
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
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
                  <button class="btn btn-primary float-right mb-4" type="submit">ADD</button>



              </div>
            </div>


          </div>

          </form>

          <script>
            $(function() {
              var date = new Date($('#valid_from').val());
              var newDate = date.toString('yyyy-MM-dd');
              $("#valid_till").prop("disabled", false);
              $('#valid_till').attr('min', convert(newDate));

              var dtToday = new Date();
              var month = dtToday.getMonth() + 1;
              var day = dtToday.getDate();
              var year = dtToday.getFullYear();
              if (month < 10)
                month = '0' + month.toString();
              if (day < 10)
                day = '0' + day.toString();

              var minDate = year + '-' + month + '-' + day;
              $('#valid_from').attr('min', minDate);
              $("#valid_from").change(function() {
                var date = new Date($('#valid_from').val());
                var newDate = date.toString('yyyy-MM-dd');

                $("#valid_till").prop("disabled", false);
                $('#valid_till').attr('min', convert(newDate));


              });
            });

            function convert(newDate) {
              var date = new Date(newDate),
                mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                day = ("0" + date.getDate()).slice(-2);
              return [date.getFullYear(), mnth, day].join("-");
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
          </script>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>