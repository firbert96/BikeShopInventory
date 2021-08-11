<?php
    session_start();
    require_once("../../function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);
    
    require_once("../../database/database.php");
    require_once("../../database/inventory.php");
    $db = new Inventory();
    $id = $_GET["id"];
    $auditor_id = $_SESSION["user_id"];

    if(isset($_POST["submit"]) || !empty($_POST["submit"]))
    {
        $quantity = (int)$_POST["quantity"];
        $changer = (int)$_POST["changer"];
        $changer_name = $_POST["changer_name"];
        $product_id = (int)$_POST["id"];
        if($quantity <= 0) 
        {
            $message = "Cannot buy product because quantity of product isn\'t enough";
            echo '<script language="Javascript" type="text/javascript">';
            echo 'alert('. json_encode($message) .');';
            echo '</script>';
        }
        else
        {
            $result = $db->editQuantity($product_id,$auditor_id,$quantity,$changer,$changer_name);
            if($result){
                $message= "Update quantity product successful";
                $header = "Refresh: 0; url=../../index.php";  
                echo '<script language="Javascript" type="text/javascript">';
                echo 'alert('. json_encode($message) .');';
                echo '</script>';
                header($header);   
            }
            else
            {
                $message = "Cannot buy product because quantity of product isn\'t enough";
                echo '<script language="Javascript" type="text/javascript">';
                echo 'alert('. json_encode($message) .');';
                echo '</script>';
            }
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

        <title>Edit Quantity</title>

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
                            <h1 class="h4 text-gray-900 mb-4">Edit Quantity Product</h1>
                        </div>
                        <form class="user" method="post">
                            <input type="hidden" name="id" value='<?php echo $id; ?>'>
                            <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="exampleInputQuantity" placeholder="Quantity" name="quantity" value="<?php if(isset($_POST['quantity'])){echo $_POST['quantity'];}else{echo '';} ?>" required>
                            </div>
                            <div class="form-group">
                                <h5 style="display:inline-block"> Choose Changer : </h5>
                                <label class="radio-inline" for="sparepart">
                                    <input type="radio" name="changer" id="buyer" value="0"  <?php if(isset($_POST['changer']) && $_POST['changer']=='0'){echo 'checked';}else{echo '';}?> required> Buyer
                                </label>
                                <label class="radio-inline" for="bicycle">
                                    <input type="radio" name="changer" id="supplier" value="1" <?php if(isset($_POST['changer']) && $_POST['changer']=='1'){echo 'checked';}else{echo '';}?>> Supplier
                                </label>
                            </div>
                            <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputChangerName" placeholder="Changer Name" name="changer_name" value="<?php if(isset($_POST['changer_name'])){echo htmlspecialchars($_POST['changer_name'], ENT_QUOTES);}else{echo '';} ?>" required>
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
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>
    </body>
</html>