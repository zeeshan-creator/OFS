<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';

include("./includes/sub_branch/code.fetchSub_branches.php");

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

      <?php if ($_SESSION['role'] == 'admin') : ?>
        <div class="row">
          <div class="col-lg-3 col-md-3">
            <a href="./create.sub_branch" class="btn btn-primary mb-3">Create Sub Branch</a>
          </div>
        </div>
      <?php endif ?>
      <table class="table" id="sub_restaurants">
        <thead>
          <tr class="text-center">
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone</th>
            <?php if ($_SESSION['role'] == 'main_branch') : ?>
              <th>Active Status</th>
            <?php endif ?>
            <?php if ($_SESSION['role'] == 'admin') : ?>
              <th>Main Branch</th>
            <?php endif ?>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          $feildName;
          if ($_SESSION['role'] == 'main_branch') {
            $feildName = 'active_status';
          }
          if ($_SESSION['role'] == 'admin') {
            $feildName = 'mainBranchName';
          }
          while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['subBranchName'] . "</td>
              <td>" . $row['email'] . "</td>
              <td>" . $row['password'] . "</td>
              <td>" . $row['phone'] . "</td>
              <td>" . $row[$feildName] . "</td>
              <td class='td-actions text-right'>
               <!-- <button type='button' rel='tooltip' title='Details' class='btn btn-info btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-single-02'></i>
                </button> -->
                <a href='update.sub_branch?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-settings'></i>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleteSub_branch(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-simple-remove'></i>
                </button>
              </td>
            </tr>";
            $count++;
          }
          ?>
        </tbody>
      </table>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->


  <script>
    $(document).ready(function() {
      $('#sub_restaurants').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deleteSub_branch(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
            $.ajax({
                url: 'code.deleteSub_branch',
                type: 'POST',
                data: {
                  subRestaurantId: id
                },
              })
              .done(function(response) {
                if (response == 1) {
                  Swal.fire('Deleted!', "Records deleted", "success");
                }
                if (response == 0) {
                  Swal.fire('INVALID ID!', "Something went wrong", "error");
                }
                location.reload();
              })
              .fail(function() {
                swal('Oops...', 'Something went wrong!', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }
  </script>
</body>

</html>