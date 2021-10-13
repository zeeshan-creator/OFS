<?php

// include './auth/login_auth.php';

// $activeNav = "";
?>

<style>
  .sidebar {
    position: relative;
    /* background:
      -moz-linear-gradient(-72deg,
        #dedede,
        #ffffff 16%,
        #dedede 21%,
        #ffffff 24%,
        #454545 27%,
        #dedede 36%,
        #ffffff 45%,
        #ffffff 60%,
        #dedede 72%,
        #ffffff 80%,
        #dedede 84%,
        #a1a1a1) !important;
    background:
      -webkit-linear-gradient(-72deg,
        #dedede,
        #ffffff 16%,
        #dedede 21%,
        #ffffff 24%,
        #454545 27%,
        #dedede 36%,
        #ffffff 45%,
        #ffffff 60%,
        #dedede 72%,
        #ffffff 80%,
        #dedede 84%,
        #a1a1a1) !important;
    background:
      -o-linear-gradient(-72deg,
        #dedede,
        #ffffff 16%,
        #dedede 21%,
        #ffffff 24%,
        #454545 27%,
        #dedede 36%,
        #ffffff 45%,
        #ffffff 60%,
        #dedede 72%,
        #ffffff 80%,
        #dedede 84%,
        #a1a1a1) !important;
    background:
      linear-gradient(-72deg,
        #dedede,
        #ffffff 16%,
        #dedede 21%,
        #ffffff 24%,
        #454545 27%,
        #dedede 36%,
        #ffffff 45%,
        #ffffff 60%,
        #dedede 72%,
        #ffffff 80%,
        #dedede 84%,
        #a1a1a1) !important; */

    background-color: #f9fcff !important;
    background-image: linear-gradient(140deg, #f9fcff 0%, #dee4ea 75%) !important;
  }

  .sidebar a,
  .sidebar p,
  .sidebar i {
    color: rgba(0, 0, 0, .6) !important;
    text-decoration: none !important;
    letter-spacing: 0.2em !important;
    font-weight: bold !important;
    text-shadow: 1px 1px 0 #ffffff !important;
  }

  .opac {
    /* can change the opacity for the silver gradient */
    opacity: 0;
    background-color: black;
    position: absolute;
  }
</style>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Black Dashboard
  </title>


  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js"></script>

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link href="./assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link href="./assets/demo/demo.css" rel="stylesheet" /> -->

  <!-- DataTables Script & CSS Links -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

  <!-- Sweet Alert Script & CSS Links -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.all.min.js"></script>

  <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>

</head>