<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/products/code.Product.php");
$id;
if (isset($_GET['branchId'])) {
  if ($_SESSION['role'] == 'admin') {
    $id = trim($_GET['branchId']);
  } else {
    echo '<script>window.location.href = "restaurantDetails";</script>';
    exit();
  }
} else {
  $id = $_SESSION['id'];
}

$category_query = "SELECT id,category_name FROM categories WHERE restaurant_id = " . $id;
$result = mysqli_query($conn, $category_query);
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
            <h3 class="card-title">Create Product</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <div class=" col-md-6 mb-3">
                  <label for="productname">Product name</label>
                  <input type="text" class="form-control" name="productName" min="3" max="15" placeholder="Enter product Name" id="productname" required>
                  <div class="invalid-feedback">
                    Please enter a product name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="price">price</label>
                  <input type="number" class="form-control" name="price" placeholder="Enter product price" id="price" required>
                  <div class="invalid-feedback">
                    Please enter a product price
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="description">Product description</label>
                  <textarea type="text" class="form-control" name="description" placeholder="Enter Product description" id="description" required></textarea>
                  <div class="invalid-feedback">
                    Please enter a Product description
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="photo">Products photo</label>
                  <input type="text" class="form-control" name="photo" placeholder="Enter photo" id="photo" required>
                  <div class="invalid-feedback">
                    Please enter a product photo
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="categoriesSelect">Category</label>
                  <select class="form-control" id="categoriesSelect" name="category" required>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                      // displaying data in option menu
                    }
                    ?>
                  </select>
                  <div class=" invalid-feedback">
                    Please enter a category
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">ADD</button>
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