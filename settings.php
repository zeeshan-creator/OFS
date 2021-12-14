<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';
include("./includes/restaurants/code.updateRestaurants.php");


$id = $_SESSION['id'];

$restaurant_query = "SELECT * FROM restaurants WHERE id='$id' LIMIT 1";
$result = mysqli_query($conn, $restaurant_query);
$row = mysqli_fetch_assoc($result);

if ($row) {
  // Retrieve individual field value
  $name = $row["name"];
  $phone = $row["phone"];
  $email = $row["email"];
  $password = $row["password"];
  $contact_name = $row['contact_name'];
  $contact_phone = $row['contact_phone'];
  $contact_email = $row['contact_email'];
  $country = $row['country'];
  $city = $row['city'];
  $street_address = $row['street_address'];
  $cuisine = $row['cuisine'];
  $active_status = $row["active_status"];
} else {
  // URL doesn't contain valid id. Redirect to allrestaurants
  // header("location: allrestaurants");
  echo '<script>window.location.href = "allrestaurants";</script>';
  exit();
}
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
            <h3 class="card-title">Restaurant Details</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <input type="hidden" name="restaurantId" value="<?php echo $id; ?>">
                <div class=" col-md-6 mb-3">
                  <label for="restaurantname">restaurant name</label>
                  <input type="text" class="form-control" value="<?php echo $name; ?>" name="restaurantName" min="3" max="15" placeholder="Enter restaurant Name" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" value="<?php echo $phone; ?>" name="restaurantPhone" placeholder="Enter restaurant phone number" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant phone number
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantEmail">restaurant E-Mail</label>
                  <input type="hidden" name="restaurantEmail" value="<?php echo $email; ?>">
                  <input type="email" class="form-control" value="<?php echo $email; ?>" name="restaurantEmail" max="55" placeholder="Enter restaurant Email" id="restaurantname" required disabled>
                  <div class="invalid-feedback">
                    Please enter a restaurant Email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantPassword">restaurant Password</label>
                  <input type="text" class="form-control" value="<?php echo $password; ?>" name="restaurantPassword" placeholder="Enter restaurant password" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_name">Contact Name</label>
                  <input type="text" class="form-control" value="<?php echo $contact_name; ?>" name="contact_name" placeholder="Enter contact name" id="contact_name" required>
                  <div class="invalid-feedback">
                    Please enter a Contact Name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_phone">Contact Phone</label>
                  <input type="number" class="form-control" value="<?php echo $contact_phone; ?>" name="contact_phone" placeholder="Enter contact phone" id="contact_phone" required>
                  <div class="invalid-feedback">
                    Please enter a contact phone
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contact_email">Contact Email</label>
                  <input type="text" class="form-control" value="<?php echo $contact_email; ?>" name="contact_email" placeholder="Enter contact email" id="contact_email" required>
                  <div class="invalid-feedback">
                    Please enter a contact email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" value="<?php echo $country; ?>" name="country" placeholder="Enter country" id="country" required>
                  <div class="invalid-feedback">
                    Please enter a country
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="city">City</label>
                  <input type="text" class="form-control" value="<?php echo $city; ?>" name="city" placeholder="Enter city" id="city" required>
                  <div class="invalid-feedback">
                    Please enter a city
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="street_address">Street Address</label>
                  <input type="text" class="form-control" value="<?php echo $street_address; ?>" name="street_address" placeholder="Enter street address" id="street_address" required>
                  <div class="invalid-feedback">
                    Please enter a street_address
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cuisine">Cuisine</label>
                  <input type="text" class="form-control" value="<?php echo $cuisine; ?>" name="cuisine" placeholder="Enter cuisine" id="cuisine" required>
                  <div class="invalid-feedback">
                    Please enter a cuisine
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="roleSelect">Active Status</label>
                  <select class="form-control" id="roleSelect" name="active_status" required>
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
                    Please select any status
                  </div>
                  <small class="ml-1 mt-1 d-block font-weight-bold">Beware of account blocking. You will not be able to log in again and will need to contact the administration.</small>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">Save</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Discard</button>
          </div>

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

            // GO BACK 
            function goBack() {
              window.history.back();
            }
          </script>
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