<!-- HEAD -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OFS</title>



  <?php
  if ($_SESSION['role'] == 'admin') {
    echo '<img src="docs/assets/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">';
    goto exiit;
  }

  if ($_SESSION['role'] == 'main_branch') {
    $query = "SELECT logo,name FROM `restaurants` WHERE `id`= " . $_SESSION['id'];
  }

  if ($_SESSION['role'] == 'sub_branch') {
    $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
    $results = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($results);
    $query = "SELECT logo,name FROM `restaurants` WHERE `id`= " . $row['main_branch'];
  }

  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);

  if ($row['logo'] == '' && $row['logo'] == null) {
    echo '<link rel="shortcut icon" href="dist\img\AdminLTELogo.png" >';
  }
  if ($row['logo'] != '' && $row['logo'] != null) {
    echo ' <link rel="shortcut icon" href="includes/restaurants/logos/' . $row['logo'] . '" type="image/x-icon">';
  }
  exiit:
  ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
  <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">

  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- jQuery -->

  <!-- DataTables Script & CSS Links -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

  <!-- Sweet Alert Script & CSS Links -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">

  <style>
    body {
      overflow-x: hidden;
    }
  </style>

</head>

<!-- 
<div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__shake" src="docs/assets/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div> -->