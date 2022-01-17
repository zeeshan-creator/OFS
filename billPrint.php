<?php include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/POS/code.fetchOffersToPOS.php");
?>

<?php if (!empty($_SESSION["shopping_cart"])) : ?>
   <div class="">
      <table>
         <thead>
            <tr class="text-bold">
               <td class="pl-2">ITEM</td>
               <td class="pl-4">QTY</td>
               <td class="pl-4">Size</td>
               <td class="pl-4">PKR</td>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($_SESSION["shopping_cart"] as $product) {
            ?>
               <tr>
                  <td class="pl-2 m-4">
                     <div class="float-left mr-4">
                        <?php echo $product["name"]; ?><br />
                     </div>
                  </td>
                  <td class="m-4">
                     <div class="">
                        <?php echo $product["quantity"]; ?><br />
                     </div>
                  </td>
                  <td class="m-4">
                     <div class="">
                        <?php if (isset($product['size']) && $product['size'] != null) {
                           $query = "SELECT * FROM `sizes` WHERE id = " . $product["size"];
                           $sizes = mysqli_query($conn, $query);
                           $row = mysqli_fetch_assoc($sizes);
                           echo $row["size"];
                        }
                        ?><br />
                     </div>
                  </td>
                  <td class="m-4">
                     <div class="float-left mx-4">
                        <?php echo $product["price"]; ?>
                     </div>
                  </td>
               </tr>
            <?php
               $subtotal += ($product["price"] * $product["quantity"]);
            }
            ?>
         </tbody>
      </table>
   </div>
<?php endif ?>

<br>
<p class="lead">Amount</p>

<div class="table-responsive">
   <table class="table">
      <tr>
         <th style="width:50%">Subtotal:</th>
         <td>PKR <?php echo $subtotal ?  $subtotal : "--.--" ?></td>
      </tr>
      <tr>
         <th>Discount:</th>
         <?php if ($subtotal >= $ordersOver) {
            $offerDiscount = round($subtotal / 100 * $offerPercentage);
         }
         ?>
         <td>PKR <?php echo $offerDiscount ? $offerDiscount : "--.--" ?></td>
      </tr>
      <?php if ($offerDiscount != null) : ?>
         <h4><?php echo $offer['offer_name'] ?></h4>
         <p><?php echo $offer['offer_percentage'] ?>% discount on orders over <?php echo $offer['order_over'] ?> </p>
      <?php endif ?>

      <tr>
         <th>Total:</th>
         <?php if ($subtotal) {
            $total = $subtotal - $offerDiscount;
            echo '<script> document.getElementById("totalPrice").value = "' . $total . '"; </script>';
         }
         ?>
         <td>PKR <?php echo $total ?  $total : "--.--" ?></td>
      </tr>
   </table>
</div>
<script>
   window.print();
</script>