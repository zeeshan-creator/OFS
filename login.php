<?php
include("./includes/code.login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page 2</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <style>
      body {
         position: relative;
         color: white;
         background: #222D32;
         font-family: 'Roboto', sans-serif;
      }

      .login-box {
         position: absolute;
         left: 50%;
         transform: translate(-50%, 25%) !important;
         background: #1A2226;
         text-align: center;
         box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
      }

      .login-key {
         height: 100px;
         text-align: center;
         font-size: 80px;
         line-height: 100px;
         background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
      }

      .login-title {
         margin-top: 15px;
         text-align: center;
         font-size: 30px;
         letter-spacing: 2px;
         margin-top: 15px;
         font-weight: bold;
         color: #ECF0F5;
      }

      .login-form {
         margin-top: 25px;
         text-align: left;
      }

      input[type=email] {
         background-color: #1A2226;
         border: none;
         border-bottom: 2px solid #0DB8DE;
         border-top: 0px;
         border-radius: 0px;
         font-weight: bold;
         outline: 0;
         margin-bottom: 20px;
         padding-left: 0px;
         color: #ECF0F5;
      }

      input[type=password] {
         background-color: #1A2226;
         border: none;
         border-bottom: 2px solid #0DB8DE;
         border-top: 0px;
         border-radius: 0px;
         font-weight: bold;
         outline: 0;
         padding-left: 0px;
         margin-bottom: 20px;
         color: #ECF0F5;
      }

      input:focus {
         outline: none !important;
         background: #1A2226 !important;
         color: white !important;
         box-shadow: 0 0 0;
      }

      .btn {
         width: auto;
         margin-left: auto;
         border-color: #0DB8DE;
         color: #0DB8DE;
         border-radius: 0px;
         font-weight: bold;
         letter-spacing: 1px;
         box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      }

      .btn:hover {
         background-color: #0DB8DE;
         right: 0px;
      }

      .form-check {
         margin-right: auto;
      }

      .foP {
         width: auto;
         margin-left: auto;
      }

      .foP a {
         color: #0DB8DE !important;
         font-weight: bold;
      }

      .foP a:hover {
         color: #0e90ad !important;
         text-decoration: none;
      }
   </style>
</head>

<body>

   <div class="container">
      <div class="row">
         <div class="col-lg-7 login-box">
            <div class="col-lg-12 login-key">
               <i class="fa fa-key" aria-hidden="true"></i>
            </div>
            <div class="col-lg-12 login-title">
               ADMIN PANEL
            </div>

            <?php include('./errors.php'); ?>


            <div class="col-lg-12 login-form">
               <div class="col-lg-12 login-form">
                  <form method="POST">
                     <!-- Email input -->
                     <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example1">Email address</label>
                        <input type="email" name="email" id="form1Example1" class="form-control" required />
                     </div>

                     <!-- Password input -->
                     <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example2">Password</label>
                        <input type="password" name="password" id="form1Example2" class="form-control" required />
                     </div>

                     <!-- 2 column grid layout for inline styling -->
                     <br>
                     <!-- Submit button -->
                     <button type="submit" class="btn btn-outline-primary btn-block mb-5">Log in</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
</body>

</html>