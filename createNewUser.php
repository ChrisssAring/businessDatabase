<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");

/** other variables */
$userNameIsUnique = true;
$passwordIsValid = true;				
$userIsEmpty = false;					
$passwordIsEmpty = false;				
$password2IsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the wisher's name in the text field "user" */    
    if ($_POST["user"]=="") {
        $userIsEmpty = true;
    }
 
    $userID = BusinessDB::getInstance()->get_user_id_by_name($_POST["user"]);
    session_start();
    $_SESSION['user'] = $_POST['user'];
    $userIDnum=mysqli_num_rows($userID);
    if ($userIDnum) {
        $userNameIsUnique = false;
    }

    if ($_POST["password"]=="") {
        $passwordIsEmpty = true;
    }
    if ($_POST["password2"]=="") {
        $password2IsEmpty = true;
    }
    if ($_POST["password"]!=$_POST["password2"]) {
        $passwordIsValid = false;
    }
    
    /** Check whether the boolean values show that the input data was validated successfully.
     * If the data was validated successfully, add it as a new entry in the "wishers" database.
     * After adding the new entry, close the connection and redirect the application to editWishList.php.
     */
    
    if (!$userIsEmpty && $userNameIsUnique && !$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        BusinessDB::getInstance()->create_user($_POST["user"], $_POST["password"]);
        header('Location: searchBusiness.php' );
        exit;
    }
}

?>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        Welcome!<br>
        <form action="createNewUser.php" method="POST">
            Your name: <input type="text" name="user"/><br/>
            <?php
            if ($userIsEmpty) {
                echo ("Enter your name, please!");
                echo ("<br/>");
            }
            if (!$userNameIsUnique) {
                echo ("The person already exists. Please check the spelling and try again");
                echo ("<br/>");
            }
            ?>
            
            Password: <input type="password" name="password"/><br/>
            <?php
            if ($passwordIsEmpty) {
                echo ("Enter the password, please!");
                echo ("<br/>");
            }                
            ?>
            
            Please confirm your password: <input type="password" name="password2"/><br/>
            <?php
            if ($password2IsEmpty) {
                echo ("Confirm your password, please");
                echo ("<br/>");    
            }                
            if (!$password2IsEmpty && !$passwordIsValid) {
                echo  ("The passwords do not match!");
                echo ("<br/>");  
            }                 
            ?>
            <input type="submit" value="Register"/>
        </form>
     </body>
</html>
