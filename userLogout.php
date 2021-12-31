<?php
session_start();
unset($_SESSION["userName"]);
unset($_SESSION['userName']);
unset($_SESSION['userEmail']);
unset($_SESSION['branchID']);
unset($_SESSION['userId']);
unset($_SESSION['userStatus']);
header("Location: userLogin");
