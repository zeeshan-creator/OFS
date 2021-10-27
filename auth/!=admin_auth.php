<?php
if ($_SESSION['role'] != 'admin') {
   // header("Location: login");
   echo '<script>window.location.href = "index";</script>';
   exit();
}
