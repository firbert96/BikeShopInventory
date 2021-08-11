<?php
    session_start();
    require_once("function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);

    require_once("database/database.php");
    require_once("database/auditors.php");

    $db= new Auditors();
    $data=$db->selectId($_SESSION["user_id"]);
    
    if(isset($_POST["edit"])){
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $id = $_SESSION["user_id"];
        if($db->editUser($fullname,$email,$phone,$id)){
            $message = "Update user successful";
            $header = "Refresh: 0; url=index.php";        
        }
        else{
            $message = "Update failed"; 
            $header = "Refresh: 0; url=editUser.php";
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

        <title>Edit User</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
                <div class="col-lg-12">
                    <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Edit User</h1>
                    </div>
                    <form class="user" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="fullname">Full Name</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control form-control-user" id="exampleInputFullName" placeholder="Full Name" name="fullname" value="<?php echo htmlspecialchars($data["fullname"], ENT_QUOTES)?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-10">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" value='<?php echo $data["email"] ?>' required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="phone">Phone Number</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control form-control-user" id="exampleInputPhone" placeholder="Phone number" name="phone" value="<?php echo htmlspecialchars($data["phone"], ENT_QUOTES)?>" required>
                                </div>
                            </div>            
                        </div>
                        <input type="submit" name="edit" value="Edit" id="edit" class="btn btn-primary btn-user btn-block">
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>

        </div>

        </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <script>
            $(document).ready(function(){
                $('#edit').hover(function(){
                    $('#edit').val("Are you sure edit <?php echo $data['fullname'] ?>?");
                },function(){
                    $('#edit').val("Edit");
                });
            });
        </script>
    </body>
</html>