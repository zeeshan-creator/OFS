<?php
include("./includes/branches/code.fetchBranches.php");
?>

<!DOCTYPE html>
<html lang="en">

<!-- Including header -->
<?php include './partials/head.php' ?>
<style>
  #branches_filter,
  #branches_filter input,
  #branches_length,
  #branches_length select,

  #branches_info,
  #branches_paginate a {
    color: white !important;
  }


  #branches_paginate span a,
  #branches_length select option {
    color: black !important;
  }

  tbody tr {
    background: none !important;
  }
</style>

<body class="" style="color: white">
  <div class="wrapper">
    <?php
    // $activeNav = "active";
    ?>
    <!-- Including sidebar -->
    <?php include './partials/sidebar.php' ?>

    <div class="main-panel">
      <!-- Navbar -->
      <!-- Including nav -->

      <?php include './partials/nav.php' ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-lg-12">
            <a href="./create.branches" class="btn btn-primary mb-3">Create Branches</a>
          </div>
        </div>
        <table class="table" id="branches">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>Phone</th>
              <th>Role</th>
              <!-- <th>Last login</th>
              <th>Login Status</th> -->
              <th>Active Status</th>
              <!-- <th>created_at</th>
              <th>updated_at</th> -->
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($results)) {
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['name'] . "</td>
              <td>" . $row['email'] . "</td>
              <td>" . $row['password'] . "</td>
              <td>" . $row['phone'] . "</td>
              <td>" . $row['role'] . "</td>
              <td>" . $row['active_status'] . "</td>
              <td class='td-actions text-right'>
               <!-- <button type='button' rel='tooltip' title='Details' class='btn btn-info btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-single-02'></i>
                </button> -->
                <a href='update.branches?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-settings'></i>
                </a>
                <button type='button' rel='tooltip' id='delete-branch' title='Delete'
                s onclick='deleteBranch(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
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

      <!-- Including footer -->
      <?php include './partials/footer.php' ?>

    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#branches').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deleteBranch(id) {
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
                url: 'code.deleteBranches',
                type: 'POST',
                data: {
                  branchId: id
                },
              })
              .done(function(response) {
                if (response == 1) {
                  Swal.fire('Deleted!', "Records deleted", "success");
                  location.reload();
                } else {
                  Swal.fire('INVALID ID!', "Something went wrong", "error");
                }
                location.reload();
              })
              .fail(function() {
                swal('Oops...', 'Something went wrong with ajax !', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }
  </script>
</body>

</html>