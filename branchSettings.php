<?php
include './auth/login_auth.php';

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
            <h3 class="card-title">Delivery Zone</h3>
          </div>

          <div class="card-body">

            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <div class=" col-lg-6 mb-3 d-flex">
                  <label for="zone" class="m-2">Zone: </label>
                  <input class="ml-2" type="text" class="form-control" name="zone" min="3" max="15" placeholder="Enter a zone name" id="zone" required>
                  <div class="invalid-feedback">
                    Please enter a zone
                  </div>
                </div>

              </div>
              <button class="btn btn-primary float-right mb-4" type="submit">ADD</button>

          </div>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

    <script>

    </script>

  </div>
  <!-- ./wrapper -->

</body>

</html>