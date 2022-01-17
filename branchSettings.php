<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/sub_branch/code.branchSetting.php");

$query = "SELECT * FROM `areas`";
$areas = mysqli_query($conn, $query);

if ($_SESSION['role'] == 'main_branch') {
  $query = "SELECT * FROM `delivery_zone` WHERE `restaurant_id` = " . $_SESSION['id'];
}
if ($_SESSION['role'] == 'sub_branch') {
  $query = "SELECT * FROM `delivery_zone` WHERE `branch_id` = " . $_SESSION['id'];
}

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
  // Retrieve individual field value
  $zoneID = $row["id"];
  $zone_name = $row["zone_name"];
}

$query = "SELECT areas.id, areas.area, zone_area.delivery_zone_id FROM `zone_area` JOIN areas on zone_area.area_id = areas.id Where zone_area.delivery_zone_id = $zoneID";
$deliveryZones = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>

<style>
  .zoneTags {
    padding: 5px;
    width: 50%;
    min-height: 120px;
    max-height: fit-content;
    border: thin solid grey
  }

  .tag {
    display: inline-block;
    width: fit-content;
    margin: 5px;
    background-color: rgba(0, 0, 0, .2);
    padding: 2px 5px;
    border-radius: 3px;
    border: thin solid grey;
  }

  .areas {
    height: 500px;
    overflow-y: auto;
  }

  .areas p:hover {
    box-shadow: 1px 1px 4px;
  }

  .no-btn {
    border: none;
    background: none;
  }
</style>

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
            <button class="btn btn-primary float-right mb-4" data-toggle="modal" data-target="#zonesModal" type="button"> <i class="fas fa-plus-circle mr-1"></i> Add Zone</button>
            <div class="form-row">
              <div class="col-lg-12 mb-3 d-flex">
                <label for="zone" class="m-2">Delivery Zones: </label>
                <div class="zoneTags">
                  <?php
                  while ($row = mysqli_fetch_assoc($deliveryZones)) {
                    echo '<span class="tag">' . $row['area'] . ' <button class="no-btn" onclick="removeZone(' . $row['id'] . ',' . $zoneID . ')"><i class="fal fa-times"></i></button></span>';
                  }
                  ?>
                </div>
              </div>
            </div>

            <!-- zones Modal -->
            <div class="modal fade" id="zonesModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Delivery Zones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="areas">
                      <?php
                      while ($area = mysqli_fetch_assoc($areas)) {
                        echo "<p><button class='no-btn w-100' onclick='addZone(" . $area['id'] . "," . $zoneID . ")'>" . $area['area'] . "</button></p>";
                      }
                      ?>
                    </div>

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.modal -->

            <hr>

            <form method="POST" class="needs-validation" novalidate>

              <div class="col-lg-6 mb-3 d-flex">
                <label for="zone" class="m-2">Zone: </label>
                <input class="ml-2" type="text" value="<?php echo $zone_name ?>" class="form-control" name="zoneName" min="3" max="15" placeholder="Enter a zone name" id="zone" required>
                <div class="invalid-feedback">
                  Please enter a zone name
                </div>
              </div>

              <button class="btn btn-primary float-right mb-4" type="submit">Save changes</button>
            </form>

          </div>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

    <script>
      function removeZone(areaID, deliveryZoneID) {
        $.ajax({
            url: 'code.removeFromZone',
            type: 'POST',
            data: {
              action: 'removeFromZone',
              areaID: areaID,
              deliveryZoneID: deliveryZoneID
            },
          })
          .done(function(response) {
            if (response == 1) {
              location.reload();
            }
            if (response == 0) {
              Swal.fire('Alreay Exist!', "Already in zones", "error");
            }
          })
          .fail(function() {
            swal('Oops...', 'Something went wrong!', 'error');
          });
      }

      function addZone(areaID, deliveryZoneID) {
        $.ajax({
            url: 'addToZone',
            type: 'POST',
            data: {
              action: 'addToZone',
              areaID: areaID,
              deliveryZoneID: deliveryZoneID
            },
          })
          .done(function(response) {
            if (response == 1) {
              location.reload();
            }
            if (response == 0) {
              Swal.fire('Alreay Exist!', "Already in zones", "error");
            }
          })
          .fail(function() {
            swal('Oops...', 'Something went wrong!', 'error');
          });
      }
    </script>

  </div>
  <!-- ./wrapper -->

</body>

</html>