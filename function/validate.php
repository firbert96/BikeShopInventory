<?php
    class Validate{
        function alreadyLogin($user_id): void{
            if(!isset($user_id)){
                $message = "User need login first";
                $header = "Refresh: 0; url=login.php";
                echo '<script language="Javascript" type="text/javascript">';
                echo 'alert('. json_encode($message) .');';
                echo '</script>'; 
                header ($header);
            }
        }
    }
?>