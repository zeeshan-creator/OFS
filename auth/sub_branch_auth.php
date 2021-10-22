<?php
if ($_SESSION['role'] == 'sub_branch') {
   // header("Location: login");
   echo '<script>window.location.href = "index";</script>';
   exit();
}
