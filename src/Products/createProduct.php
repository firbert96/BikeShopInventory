<?php
    session_start();
    require_once("../../function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);
    
	require_once("../../database/database.php");
    require_once("../../database/inventory.php");

    if(isset($_POST["submit"])){
        $db= new Inventory();
        $auditor_id = $_SESSION["user_id"];
        $product_name = $_POST["product_name"];
        $product = (int)$_POST["product"];
        if($db->insert($auditor_id,$product_name,$product)){
            $message = "Create new product successful";
            echo '<script language="Javascript" type="text/javascript">';
            echo 'alert('. json_encode($message) .');';
            echo '</script>'; 
            $header = "Refresh: 0; url=../../index.php";
            header($header);
        }
        else{
            $message = "Create new product failed";
            echo '<script language="Javascript" type="text/javascript">';
            echo 'alert('. json_encode($message) .');';
            echo '</script>';
        }
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

        <title>Create New Product</title>

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
                    <div class="col-lg-12">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create New Product</h1>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputProductName" placeholder="Product Name" name="product_name" value="<?php if(isset($_POST['product_name'])){echo htmlspecialchars($_POST['product_name'], ENT_QUOTES);}else{echo '';}?>" required>
                            </div>
                            <div class="form-group">
                                <h5 style="display:inline-block"> Choose Product : </h5>
                                <label class="radio-inline" for="sparepart">
                                    <input type="radio"name="product" id="sparepart" value="0" <?php if(isset($_POST['product']) && $_POST['product']=='0'){echo 'checked';}else{echo '';}?> required>Sparepart
                                </label>
                                <label class="radio-inline" for="bicycle">
                                    <input type="radio" name="product" id="bicycle" value="1" <?php if(isset($_POST['product']) && $_POST['product']=='1'){echo 'checked';}else{echo '';}?>>Bicycle
                                </label>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Create">
                        </form>
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
        <script src="../..//bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <script>
            
        </script>
    </body>
</html>