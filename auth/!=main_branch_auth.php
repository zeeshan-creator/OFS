<?php
if ($_SESSION['role'] != 'main_branch') {
   // header("Location: login");
   echo '<script>window.location.href = "index";</script>';
   exit();
}
