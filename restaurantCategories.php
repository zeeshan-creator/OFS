<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';
include("./includes/restaurants/categories/code.fetchCategories.php");

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
      <div class="row">
        <div class="col-lg-5 ml-3 mt-4 mb-2">
          <h1 class="">
            <span style="border-bottom: 3px double black;">
              Categories
            </span>
          </h1>
        </div>
        <div class="col-lg-6 ml-auto mt-4 p-4">
          <a href="./create.restaurantsCategory" class="btn btn-primary float-right">Add Categories</a>
        </div>
      </div>

      <div class="p-3">
        <table class="table" id="restaurantCategories">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Category</th>
              <th>Description</th>
              <th>No. of products</th>
              <th>Status</th>
              <th>Publish Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($categories)) {
              $query = "SELECT COUNT(`id`) AS NumberOfProducts FROM products Where `category_id` =" . $row['id'];
              $result = mysqli_query($conn, $query);
              $no = mysqli_fetch_assoc($result);
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['category_name'] . "</td>
              <td>" . $row['category_desc'] . "</td>
              <td>" . $no['NumberOfProducts'] . "</td>
              <td>" . $row['active_status'] . "</td>
              <td>" . $row['created_at'] . "</td>
              <td class='td-actions text-right'>
                <a href='update.restaurantCategories?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='far fa-edit'></i>
                  </span>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleterestaurantCategory(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
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
      $('#restaurantCategories').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deleterestaurantCategory(id) {
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
                url: 'code.deleteRestaurantCategory',
                type: 'POST',
                data: {
                  id: id
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