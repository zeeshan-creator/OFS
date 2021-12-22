<?php
include './auth/login_auth.php';
include './auth/!=admin_auth.php';
include("./includes/sub_branch/code.sub_branch.php");

$restaurant_query = "SELECT id,name, email FROM restaurants";
$restaurants = mysqli_query($conn, $restaurant_query);
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
            <h3 class="card-title">Create Sub Branch</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="restaurantname">Restaurant Name</label>
                  <input type="text" class="form-control" name="restaurantName" min="3" max="15" placeholder="Enter restaurant Name" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" name="restaurantPhone" placeholder="Enter restaurant phone number" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant phone number
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="restaurantEmail">Restaurant E-Mail</label>
                  <input type="email" class="form-control" name="restaurantEmail" max="55" placeholder="Enter restaurant Email" id="restaurantEmail" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant Email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantPassword">Restaurant Password</label>
                  <input type="text" class="form-control" name="restaurantPassword" placeholder="Enter restaurant password" id="restaurantPassword" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_name">Contact Name</label>
                  <input type="text" class="form-control" name="contact_name" placeholder="Enter contact name" id="contact_name" required>
                  <div class="invalid-feedback">
                    Please enter a Contact Name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_phone">Contact Phone</label>
                  <input type="number" class="form-control" name="contact_phone" placeholder="Enter contact phone" id="contact_phone" required>
                  <div class="invalid-feedback">
                    Please enter a contact phone
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_email">Contact Email</label>
                  <input type="text" class="form-control" name="contact_email" placeholder="Enter contact email" id="contact_email" required>
                  <div class="invalid-feedback">
                    Please enter a contact email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" name="country" placeholder="Enter country" id="country" required>
                  <div class="invalid-feedback">
                    Please enter a country
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="city">City</label>
                  <input type="text" class="form-control" name="city" placeholder="Enter city" id="city" required>
                  <div class="invalid-feedback">
                    Please enter a city
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="street_address">Street Address</label>
                  <input type="text" class="form-control" name="street_address" placeholder="Enter street address" id="street_address" required>
                  <div class="invalid-feedback">
                    Please enter a street_address
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cuisine">Cuisine</label>
                  <input type="text" class="form-control" name="cuisine" placeholder="Enter cuisine" id="cuisine" required>
                  <div class="invalid-feedback">
                    Please enter a cuisine
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">save</button>
            </form>

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
            </script>

          </div>
        </div>
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