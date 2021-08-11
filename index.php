<?php
    session_start();
    require_once("function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);

	require_once("database/database.php");
    require_once("database/inventory.php");
    require_once("database/auditors.php");
    $db = new Inventory();
    $db_auditor = new Auditors();

    $fullname = $db_auditor->selectId($_SESSION["user_id"])['fullname'];
    $limit_page = 10;
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page>1) ? ($page * $limit_page) - $limit_page : 0;
    
    if(isset($_GET["search"])){
        $result = $db->search($_GET["input_search"],$start,$limit_page);
        $total = $db->countSearch($_GET["input_search"])[0];
    }
    else{
        $result = $db->selectAll($start,$limit_page);
        $total = $db->countSelectAll()[0];
    }
    $pages = ceil($total/$limit_page); 
    $no =$start+1;

?>

<!DOCTYPE html>
<html lang="en">
    <head >
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Home</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="css/font_nunito.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

        <style>
            .blue{              
                border: 3px solid blue;
                border-radius: 20px;
                margin: 5px;
            }
            .center{
                text-align: center;
            }
        </style>
    </head>
    <body id="page-top">

        
    <!-- template -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Bike Shop Inventory</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tabel Inventory</span></a>
        </li>

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="src/Products/createProduct.php">
            <i class="fa fa-list-alt"></i>
            <span>Create New Product</span></a>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                        </div>
                    </div>
                    </form>
                </div>
                </li>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow ">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fullname ?></span>
                    <img class="img-profile rounded-circle" src="img/user.jpg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="src/Users/editUser.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Edit User
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                    </a>
                </div>
                </li>

            </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1>
            <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p> -->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Inventory</h6>
            </div>
            <form>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <input type="text" name="input_search"  class="form-control form-control-user" placeholder="Search Product Name" value="<?php if(isset($_GET['input_search'])){echo $_GET['input_search'];}else{echo '';} ?>">      
                        </div>
                        <div class="col-lg-6 col-md-4">
                            <button type="submit" name="search" class="btn btn-success btn-icon-split"><span class="text">Search</span></button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                        <thead>
                            <?php
                                // var_dump(mysqli_num_rows($result));
                                if(mysqli_num_rows($result)!=0){
                                    echo "<th class='center'>No</th>";
                                    echo "<th class='center'>Product Name</th>";
                                    echo "<th class='center'>Product</th>";
                                    echo "<th class='center'>Quantity</th>";
                                    echo "<th class='center'>Auditor Name</th>";
                                    echo "<th class='center'>Auditor Email</th>";
                                    echo "<th class='center'>Action</th>";
                                }
                                else{
                                    echo "<h3 class='center'>Product not found</h3>";
                                }
                            ?>          
                        </thead>
                        <tbody>
                            <?php      
                                // var_dump($result);        
                                while($row = mysqli_fetch_assoc($result)){
                                    $product_exp = ($row["product"] == 0 ) ? 'Sparepart' : 'Bicycle';
                                    $auditor = $db_auditor->selectId($row['auditor_id']);
                                    echo "<tr>";
                                    echo "<td class='center'>".$no++."</td>";
                                    echo "<td class='center'>".$row['product_name']."</td>";
                                    echo "<td class='center'>".$product_exp."</td>";
                                    echo "<td class='center'>".$row['quantity']."</td>";
                                    echo "<td class='center'>".$auditor['fullname']."</td>";
                                    echo "<td class='center'>".$auditor['email']."</td>";
                                    echo "<td class='center'>";
                                    
                                    //edit product 
                                    echo "<a href='src/Products/editProduct.php?id=".$row['id']."' class='btn btn-primary' style='margin:10px'>";
                                    echo "<span class='text'>Edit Product</span>";
                                    echo "</a>";

                                    //edit quantity
                                    echo "<a href='src/Products/editQuantity.php?id=".$row['id']."' class='btn btn-warning' style='margin:10px'>";
                                    echo "<span class='text'>Edit Quantity</span>";
                                    echo "</a>";

                                    //delete

                                    echo "<button id='".$row['id']."' class='btn btn-danger delete' style='margin:10px'>";
                                    echo "<span class='text'>Delete Product</span>";
                                    echo "</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <div style="float:right">
                        <?php for ($i=1; $i<=$pages ; $i++){ 
                            if(isset($_GET["search"])){ ?>
                                <a class="btn btn-primary btn-circle" href="?page=<?php echo $i; ?>&input_search=<?php echo $_GET["input_search"] ?>&search=<?php $_GET["search"] ?>"><?php echo $i; ?></a>
                    <?php   }
                            else{ ?>
                                <a class="btn btn-primary btn-circle" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php   }    
                        } ?>
                    </div> 
                </div>
            </div>
            </form>

            </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2020</span>
            </div>
            </div>
        </footer>
        <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="src/Users/logout.php">Logout</a>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function(){
            $('#userDropdown').hover(function(){
                $('#userDropdown').addClass("blue");
            },
            function(){
                $('#userDropdown').removeClass("blue");
            });

            $('.delete').click(function(){
                // alert(this.id);
                var id = this.id;
                $.ajax({
                    type: "GET",
                    url: 'src/Products/deleteProduct.php?id='+id,
                    data: {},
                    success: function(response)
                    {
                        alert("Success delete product");
                    }
                });
            });
        });
    </script>
    
    </body>
</html>