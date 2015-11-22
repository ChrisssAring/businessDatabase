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
    $logonSuccess = (BusinessDB::getInstance()->verify_user_credentials($_POST['user'], $_POST['userpassword']));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: searchBusiness.php');
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
        <div id="content">
        <div class="logon">
        <form name="logon" action="loginUser.php" method="POST" >
            Username: <input type="text" name="user">
            Password  <input type="password" name="userpassword">
            <input type="submit" value="Start My Search!">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            if (!$logonSuccess) {
                echo ('<div class="error">Invalid name and/or password</div>');
            }
        }
        ?>
        </div>
        </div>
    </body>
</html>
