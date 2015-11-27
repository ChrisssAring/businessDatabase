<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessDatabase\\Includes\\dp.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
            // Verify data
            $email = mysql_escape_string($_GET['email']); // Set email variable
            $hash = mysql_escape_string($_GET['hash']); // Set hash variable
        }
        $search = BusinessDB::getInstance()->check_business_hash($email, $hash);
        $match  = mysqli_num_rows($search);
        if($match > 0){
            echo "Success! Your account has been verified! You may now login!";
            $updateAccount = BusinessDB::getInstance()->update_business_account($email, $hash);
        }else{
            echo "Failed! Invalid URL or account has already been activated!";
        }
        ?>
    </body>
</html>
