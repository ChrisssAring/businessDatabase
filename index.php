<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");
$logonUserSuccess = false;
$logonBusinessSuccess = false;

//verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonUserSuccess = (BusinessDB::getInstance()->verify_user_credentials($_POST['user'], $_POST['userpassword']));
    echo $logonUserSuccess;
    $logonBusinessSuccess = (BusinessDB::getInstance()->verify_business_credentials($_POST['user'], $_POST['userpassword']));
    echo $logonBusinessSuccess;
    if ($logonUserSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: searchBusiness.php');
        exit;
    } else if ($logonBusinessSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: editBusinessInformation.php');
        exit;
    }
}
?>

<html lang="en">
    <head>
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>" /> 
    <meta charset="utf-8" />
    </head>
    <body>
        <h2>Assist-Base</h2>
        
        <span href="#" class="button" id="toggle-login">Log in</span>
        <div id="login">
        <div id="triangle"></div>
        <h1>Log in</h1>
        <form name="logon" action="index.php">
            <input type="text" placeholder="Username" name="user" />
            <input type="password" placeholder="Password" name="userpassword" />
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if (!$logonUserSuccess || !$logonBusinessSuccess) {
                    echo "Invalid name and/or password";
                }
            }
            ?>
            </p>
            <br>
            <input type="submit" value="Log in" formmethod="POST" /> <br><br>
            <input type="submit" value="Register" formaction="createNewAccount.php" />
        </form>
        </div>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="js/index.js"></script>        
    </body>
</html>
