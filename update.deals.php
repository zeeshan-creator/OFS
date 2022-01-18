<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.updateDeal.php");
include("./includes/restaurants/deals/code.fetchProducts.php");
include("./includes/restaurants/deals/code.fetchSelects.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>

<style>
  .quantity {
    position: relative;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }

  .quantity input {
    width: 75px;
    height: 42px;
    line-height: 1.65;
    float: left;
    display: block;
    padding: 0;
    margin: 0;
    padding-left: 20px;
    border: none;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08);
    font-size: 1rem;
    border-radius: 4px;
  }

  .quantity input:focus {
    outline: 0;
  }

  .quantity-nav {
    float: left;
    position: relative;
    height: 42px;
  }

  .quantity-button {
    position: relative;
    cursor: pointer;
    border: none;
    border-left: 1px solid rgba(0, 0, 0, 0.08);
    width: 21px;
    text-align: center;
    color: #333;
    font-size: 13px;
    font-family: "FontAwesome" !important;
    line-height: 1.5;
    padding: 0;
    background: #FAFAFA;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
  }

  .quantity-button:active {
    background: #EAEAEA;
  }

  .quantity-button.quantity-up {
    position: absolute;
    height: 50%;
    top: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    font-family: "FontAwesome";
    border-radius: 0 4px 0 0;
    line-height: 1.6
  }

  .quantity-button.quantity-down {
    position: absolute;
    bottom: 0;
    height: 50%;
    font-family: "FontAwesome";
    border-radius: 0 0 4px 0;
  }

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

  .redAsterick:after {
    content: " *";
    color: red;
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
            <h3 class="card-title">Update Deal</h3>
          </div>

          <div class="card-body">
            <?php include('./errors.php'); ?>

            <div class="row">
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12">
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                      <div class="col-md-5 mb-3 ">
                        <label for="product_image" class="d-block redAsterick">Deal Logo</label>
                        <input type="hidden" name="oldImage" value="<?php echo $photo; ?>">
                        <div class="d-flex">
                          <img src="includes/restaurants/deals/deals_imgs/<?php echo $photo; ?>" style="width: 100px;" class="elevation-2" id="product_image" alt="Product Image">
                          <div class="col-md-12 mb-3">
                            <input type="file" class="form-control-file ml-4 mt-4 border rounded p-1" name="newImage" accept='image/*' onchange="readURL(this)" id="newImage" required>
                            <div class="invalid-feedback">
                              Please select a deal image
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">

                        <div class=" col-lg-6 mb-3">
                          <input type="hidden" name="dealID" value="<?Php echo $dealID   ?>">
                          <input type="hidden" name="action" value="update">
                          <label for="dealName" class="redAsterick">Deal name</label>
                          <input type="text" class="form-control" value="<?Php echo $name ?>" name="dealName" min="3" max="15" placeholder="Enter deal Name" id="dealName" required>
                          <div class="invalid-feedback">
                            Please enter a deal name
                          </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="price" class="redAsterick">price</label>
                          <input type="number" class="form-control" value="<?Php echo $price ?>" name="dealPrice" placeholder="Enter deal price" id="price" required>
                          <div class="invalid-feedback">
                            Please enter a deal price
                          </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                          <label for="description" class="redAsterick">Deal description</label>
                          <textarea onkeyup="textAreaAdjust(this)" type="text" class="form-control" name="dealDesc" placeholder="Enter deal description" id="description" required><?Php echo $description ?></textarea>
                          <div class="invalid-feedback">
                            Please enter a deal description
                          </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="activeStatus" class="redAsterick">Active Status</label>
                          <select class="form-control" id="activeStatus" name="active_status" required>
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
                            Please enter a active status
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">Save Changes</button>
                          <button type="button" onclick="window.history.back()" class="btn btn-danger float-right" style="margin-right: 5px;">
                            Discard
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8">
              <hr>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8">
              <button class="btn btn-primary float-right mb-4" onclick="addToSelects(<?php echo $deal_id ?>,<?php echo $restaurant_id ?>)" type="button"> <i class="fas fa-plus-circle mr-1"></i>Add Select</button>
              <br>
              <table class="table">
                <thead>
                  <th>#</th>
                  <th>Name</th>
                  <th>Products</th>
                  <th></th>
                </thead>
                <tbody>
                  <?php
                  $count = 0;
                  while ($deal_select = mysqli_fetch_assoc($deal_selects)) {
                    $count++;
                    echo '<tr><td>' . $count . '</td>';
                    echo '<td class="w-25"><input onchange="updateSelectName(this,' . $deal_select['id'] . ')" placeholder="Enter Select Name" style="border:none; text-decoration: underline" type="text" value="' . $deal_select['select_name'] . '"></td>';

                    echo '<td><div class="zoneTags">';
                    include("./includes/restaurants/deals/code.fetchSelectProducts.php");
                    while ($row = mysqli_fetch_assoc($selectProducts)) {
                      if ($row['deal_select_id'] == $deal_select['id']) {
                        echo '<span class="tag">' . $row['name'] . ' <button class="no-btn" onclick="removeSelectProduct(' . $row['id'] . ')">
                        <i class="fal fa-times"></i></button></span>';
                      }
                    }
                    echo '</div></td>';
                    echo '<td class="w-25"><div class="pl-2 float-right">
                    <button type="button" onclick="getDealselect(this)" value="' . $deal_select['id'] . '" data-toggle="modal" data-target="#zonesModal" class="remove btn btn-info"><span style="color:white;"><i class="fas fa-plus-circle"></i></span></button>
                    <button type="button" onclick="removeFromSelects(' . $deal_select['id'] . ')" class="remove btn btn-danger"><span style="color:white;"><i class="fas fa-trash-alt"></i></span></button>
                    </div></td></tr>';
                  } ?>
                </tbody>
              </table>

              <!-- zones Modal -->
              <div class="modal fade" id="zonesModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Products</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="areas">
                        <?php
                        while ($product = mysqli_fetch_assoc($products)) {
                          echo "<p><button class='no-btn w-100' onclick='addProduct(" . $product['id'] . ")'>" . $product['productName'] . "</button></p>";
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

            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>

  </div>
  <!-- ./wrapper -->


  <script>
    $select_id;

    function textAreaAdjust(element) {
      element.style.height = "1px";
      element.style.height = (25 + element.scrollHeight) + "px";
    }

    function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function(e) {
          document.querySelector("#product_image").setAttribute("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
      }
    };

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

    function addToSelects(dealID, Restaurant_id) {
      $.ajax({
          url: 'addToSelects',
          type: 'POST',
          data: {
            dealID: dealID,
            action: "addToSelect",
            Restaurant_id: Restaurant_id,
          },
        })
        .done(function(response) {
          location.reload();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function removeFromSelects(id) {
      $.ajax({
          url: 'code.removeFromSelects',
          type: 'POST',
          data: {
            ID: id,
          },
        })
        .done(function(response) {
          location.reload();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function updateSelectName(name, id) {
      $.ajax({
          url: 'code.updateSelectName',
          type: 'POST',
          data: {
            ID: id,
            action: 'updateSelectName',
            name: name.value,
          },
        })
        .done(function(response) {
          location.reload();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function getDealselect(btn) {
      $select_id = btn.value;
    }

    function addProduct(productID, selectID) {
      $.ajax({
          url: 'addToSelects',
          type: 'POST',
          data: {
            action: 'addToSelectProduct',
            productID: productID,
            selectID: $select_id
          },
        })
        .done(function(response) {
          location.reload();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }

    function removeSelectProduct(productID) {
      $.ajax({
          url: 'code.removeFromSelectProducts ',
          type: 'POST',
          data: {
            ID: productID,
          },
        })
        .done(function(response) {
          location.reload();
        })
        .fail(function() {
          swal('Oops...', 'Something went wrong!', 'error');
        });
    }
  </script>

</body>

</html>