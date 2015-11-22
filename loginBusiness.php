<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");
$logonSuccess = false;

//verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (BusinessDB::getInstance()->verify_business_credentials($_POST['user'], $_POST['userpassword']));
    echo $logonSuccess;
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: editBusinessInformation.php');
        exit;
    }
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form name="logon" action="loginBusiness.php" method="POST" >
            Username (Name of Business): <input type="text" name="user">
            Password: <input type="password" name="userpassword">
            <input type="submit" value="Edit my Business!">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            if (!$logonSuccess) {
                echo "Invalid name and/or password";
            }
        }
        ?>
    </body>
</html>
