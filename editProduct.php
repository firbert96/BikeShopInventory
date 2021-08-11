<?php
    session_start();
    require_once("function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);
    
    require_once("database/database.php");
    require_once("database/inventory.php");

    $db = new Inventory();
    $id= $_GET["id"];
    $data = $db->selectId($id);

    if(isset($_POST["submit"])){
        $auditor_id = $_SESSION["user_id"];
        $product_name = $_POST["product_name"];
        $product = (int)$_POST["product"];
        $product_id = $_POST["id"];
        if($db->editProduct($auditor_id,$product_name,$product,$product_id)){
            $message = "Edit product successful";
            $header = "Refresh: 0; url=index.php";
        }
        else{
            $message = "Edit product failed";
            $header = "Refresh: 0; url=editProduct.php?id=".$product_id;
        }
        echo '<script language="Javascript" type="text/javascript">';
        echo 'alert('. json_encode($message) .');';
        echo '</script>'; 
        header($header);
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Edit Product</title>

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
                            <h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
                        </div>
                        <form class="user" method="post">
                            <input type="hidden" name="id" value='<?php echo $id; ?>'>
                            <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputProductName" placeholder="Product Name" name="product_name" value="<?php echo htmlspecialchars($data["product_name"], ENT_QUOTES)?>" required>
                            </div>
                            <div class="form-group">
                                <h5 style="display:inline-block"> Choose Product : </h5>
                                <label class="radio-inline" for="sparepart">
                                    <input type="radio"name="product" id="sparepart" <?php if($data["product"] == 0){ echo 'checked';}?> value="0">Sparepart
                                </label>
                                <label class="radio-inline" for="bicycle">
                                    <input type="radio" name="product" id="bicycle" <?php if($data["product"] == 1){ echo 'checked';}?> value="1">Bicycle
                                </label>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Edit">
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
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
    </body>
</html>