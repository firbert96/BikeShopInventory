<?php
    session_start();
	require_once("../../database/database.php");
    require_once("../../database/auditors.php");

    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $db = new Auditors();
        $user_id = $db->login($email, $password);
        if ($user_id != -1) {
            $_SESSION ["user_id"] = $user_id;
            $message = "Login successful";
            $header = "Refresh: 0; url=../../index.php";
        }
        else {
            $message = "Login failed, email or password is wrong";
            $header = "Refresh: 0; url=login.php";
        }

        echo '<script language="Javascript" type="text/javascript">';
        echo 'alert('. json_encode($message) .');';
        echo '</script>';
        header($header);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Login</title>

        <!-- Custom fonts for this template-->
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../../css/font_nunito.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body class="bg-gradient-primary">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class=" h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" required>
                            </div>
                            <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required>
                            </div>
                            <input type="submit" class="login btn btn-primary btn-user btn-block" name="submit" value="Login"/>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="register.php">Create an Account!</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            </div>

            </div>
        </div>


        <!-- Bootstrap core JavaScript-->
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <!-- self made -->
        <script>
            $(document).ready(function(){
                $(".login").hover(function(){
                    $(".login").val("Login Now!");
                },
                function(){
                    $(".login").val("Login");
                });

            });
        </script>
    </body>
</html>