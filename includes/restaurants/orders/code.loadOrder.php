<?php

ob_start();
session_start();
require('../../../config/db.php');


if ($_SESSION['role'] == 'main_branch') {
   $query = "SELECT * FROM `orders` WHERE `restaurant_id` =" . $_SESSION['id'] . " ORDER BY `id` DESC";
}

if ($_SESSION['role'] == 'sub_branch') {
   $query = "SELECT * FROM `orders` WHERE `branch_id` =" . $_SESSION['id'] . " ORDER BY `id` DESC";
}

$orders = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($orders)) {
   echo "<tr class='text-center'>
              <td>" . $row['id'] . "</td>
              <td>" . $row['order_type'] . "</td>
              <td>" . $row['customer_name'] . "</td>
              <td>" . $row['customer_phone'] . "</td>
              <td>" . $row['customer_email'] . "</td>
              <td>" . $row['order_date'] . " " . $row['order_time'] .  "</td>
              <td>" . $row['total_price'] . "</td>
              <td>" . $row['current_status'] . "</td>";

   if ($_SESSION['role'] == 'main_branch') {
      echo "<td class='td-actions text-right'>
                          <a href='orderDetails?orderID=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-info btn-link btn-icon btn-sm'>
                            <span style='color:white;'>
                              <i class='fas fa-info-circle'></i>
                            </span>
                          </a>
                        </td>
                      </tr>";
   }
}
