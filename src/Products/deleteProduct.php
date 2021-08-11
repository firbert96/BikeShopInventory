<?php
    session_start();
	require_once("../../database/database.php");
    require_once("../../database/inventory.php");
    require_once("../../function/validate.php");
    $validate = new Validate();
    $validate->alreadyLogin($_SESSION["user_id"]);
    $db = new Inventory();
    if($db->delete($_GET["id"])){
        $message = "Delete user successful";
        $header = "Refresh: 0; url=../../index.php"; 
        echo '<script language="Javascript" type="text/javascript">';
        echo 'alert('. json_encode($message) .');';
        echo '</script>'; 
        header ($header);
    }

?>