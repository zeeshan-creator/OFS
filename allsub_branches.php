<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';

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

      <div class="row  ">
        <div class="col-lg-12 col-md-12 ml-3 mt-3">
          <h1 class="">
            <span style="border-bottom: 3px double;">
              SUB-BRANCHES
            </span>
          </h1>
        </div>
      </div>

      <div class="p-3">
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
                <a href='update.sub_branch?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='far fa-edit'></i>
                  </span>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleteSub_branch(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='fas fa-trash-alt'></i>
                  </span>
                </button>
              </td>
            </tr>";
              $count++;
            }
            ?>
          </tbody>
        </table>
      </div>

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