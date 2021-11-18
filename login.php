<?php
include("./includes/code.login.php");
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Including Header -->
<?php include './partials/head.php' ?>

<body class="hold-transition login-page">
  <div class="login-box w-50">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="" class="h1"><b>OFS</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg h5 my-2">Sign in to start your session</p>
        <div class="er">
          <?php include('./errors.php'); ?>
        </div>
        <form method="post">
          <div class="input-group mb-4">
            <input type="email" class="form-control py-4" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-4">
            <input type="password" class="form-control py-4" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 ml-auto">
              <button type="submit" class="btn btn-primary btn-block p-2 my-2"><span class="h5">Sign In</span></button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>