<?php
include("./includes/branches/code.updateBranches.php");
if (!isset($_GET['id'])) {
   ob_start();
   if (!isset($_SESSION['name'])) {
      header("Location: allbranches");
      exit();
   }
}

if (isset($_GET['id'])) {
   $id = trim($_GET['id']);

   $branch_query = "SELECT * FROM branches WHERE id='$id' LIMIT 1";
   $result = mysqli_query($conn, $branch_query);
   $row = mysqli_fetch_assoc($result);

   if ($row) {
      // Retrieve individual field value
      $name = $row["name"];
      $phone = $row["phone"];
      $email = $row["email"];
      $password = $row["password"];
      $role = $row["role"];
      $active_status = $row["active_status"];
   } else {
      // URL doesn't contain valid id. Redirect to allbranches
      // header("location: allbranches");
      echo 'window.location.href = "allbranches";';
      exit();
   }
}
ob_end_flush();

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including header -->
<?php include './partials/head.php' ?>
<style>
   option {
      color: black !important;
   }
</style>

<body class="">
   <div class="wrapper">

      <!-- Including sidebar -->
      <?php include './partials/sidebar.php' ?>


      <div class="main-panel">
         <!-- Navbar -->
         <!-- Including nav -->

         <?php include './partials/nav.php' ?>
         <!-- End Navbar -->
         <div class="content">
            <div class="row">
               <div class="card">
                  <div class="card-body">
                     <?php include('./errors.php'); ?>
                     <form method="POST" class="needs-validation" novalidate>
                        <div class="form-row">
                           <input type="hidden" name="branchId" value="<?php echo $id; ?>">
                           <div class=" col-md-6 mb-3">
                              <label for="Branchname">Branch name</label>
                              <input type="text" class="form-control" value="<?php echo $name; ?>" name="branchName" min="3" max="15" placeholder="Enter branch Name" id="Branchname" required>
                              <div class="invalid-feedback">
                                 Please enter a Branch name
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="phone">Phone</label>
                              <input type="number" class="form-control" value="<?php echo $phone; ?>" name="branchPhone" placeholder="Enter branch phone number" id="phone" required>
                              <div class="invalid-feedback">
                                 Please enter a Branch phone number (min=11, max=13)
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="branchEmail">Branch E-Mail</label>
                              <input type="email" class="form-control" value="<?php echo $email; ?>" name="branchEmail" max="55" placeholder="Enter branch Email" id="Branchname" required>
                              <div class="invalid-feedback">
                                 Please enter a Branch Email
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="branchPassword">Branch Password</label>
                              <input type="text" class="form-control" value="<?php echo $password; ?>" name="branchPassword" min="6" max="16" placeholder="Enter branch password" id="phone" required>
                              <div class="invalid-feedback">
                                 Please enter a Branch password
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="roleSelect">Role</label>
                              <select class="form-control" id="roleSelect" name="role" required>
                                 <?php
                                 if ($role == "main_branch") {
                                    echo '<option value="main_branch" selected>Main Branch</option>
                                    <option value="sub_branch" >Sub Branch</option>';
                                 }
                                 if ($role == "sub_branch") {
                                    echo '<option value="sub_branch" selected>Sub Branch</option>
                                    <option value="main_branch">Main Branch</option>';
                                 }
                                 ?>
                              </select>
                              <div class="invalid-feedback">
                                 Please enter a Branch password
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
                                 Please enter a Branch password
                              </div>
                           </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">Submit form</button>
                        <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Cancel</button>
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

         <!-- Including footer -->
         <?php include './partials/footer.php' ?>

      </div>
   </div>

</body>

</html>