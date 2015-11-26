<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessDatabase\\Includes\\dp.php");

/** other variables */
$businessNameIsUnique = true;
$userNameIsUnique = true;
$UserAccountEmailIsUnique = true;
$BusinessAccountEmailIsUnique = true;
$passwordIsValid = true;				
$userIsEmpty = false;
$accountEmailIsEmpty = false;
$passwordIsEmpty = false;				
$password2IsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    if ($_POST["user"]=="") {
        $userIsEmpty = true;
    }

    if ($_POST["accountEmail"]=="") {
        $accountEmailIsEmpty = true;
    }
    
    session_start();
    $_SESSION['user'] = $_POST['user'];
    
    $userID = BusinessDB::getInstance()->get_user_id_by_name($_POST["user"]);
    $userIDnum=mysqli_num_rows($userID);
    if ($userIDnum) {
        $userNameIsUnique = false;
    }
    
    $UserAccountEmailID = BusinessDB::getInstance()->get_user_accountEmail_id_by_name($_POST["accountEmail"]);
    $UserAccountEmailIDnum=mysqli_num_rows($UserAccountEmailID);
    if ($UserAccountEmailIDnum) {
        $UserAccountEmailIsUnique = false;
    }
    
    $BusinessAccountEmailID = BusinessDB::getInstance()->get_business_accountEmail_id_by_name($_POST["accountEmail"]);
    $BusinessAccountEmailIDnum=mysqli_num_rows($BusinessAccountEmailID);
    if ($BusinessAccountEmailIDnum) {
        $BusinessAccountEmailIsUnique = false;
    }
    
    $businessID = BusinessDB::getInstance()->get_business_id_by_name_only($_POST["user"]);
    $businessIDnum=mysqli_num_rows($businessID);
    if ($businessIDnum) {
        $businessNameIsUnique = false;
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
    
    if (!$userIsEmpty && $userNameIsUnique && $businessNameIsUnique && $BusinessAccountEmailIsUnique && $UserAccountEmailIsUnique && !$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        if (isset($_POST['isBusiness'])) {
        BusinessDB::getInstance()->create_business($_POST["user"], $_POST["accountEmail"], $_POST["password"]);
        header('Location: editBusinessInformation.php' );
        exit;
        } else if (!isset($_POST['isBusiness']))
        BusinessDB::getInstance()->create_user($_POST["user"], $_POST["accountEmail"], $_POST["password"]);
        header('Location: searchBusiness.php' );
        exit;
    }
}

?>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>" /> 
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <span href="#" class="button" id="toggle-login">Register</span>
        <div id="login">
        <div id="triangle"></div>
        <h1>Register</h1>
        <form action="createNewAccount.php" method="POST">
            <input type="text" placeholder="Username" name="user" /><br>
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if (!$businessNameIsUnique || !$userNameIsUnique) {
                    echo "That account name is taken.";
                }
            }
             if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if ($userIsEmpty) {
                    echo "Please enter a usename.";
                }
            }
            ?>
            </p>
            <input type="text" placeholder="Email" name="accountEmail" /><br>
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if (!$UserAccountEmailIsUnique || !$BusinessAccountEmailIsUnique) {
                    echo "That email account is already in use.";
                }
            }
             if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if ($accountEmailIsEmpty) {
                    echo "Please enter an email.";
                }
            }
            ?>
            </p>
            <input type="password" placeholder="Password" name="password" /><br>
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if ($passwordIsEmpty) {
                    echo "Please enter a password.";
                }
            }
            ?>
            </p>
            <input type="password" placeholder="Confirm Password" name="password2" /><br>
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if ($password2IsEmpty) {
                    echo "Please confirm your password.";
                }
            }
            ?>
            </p>
            <input type="submit" value="Register" /> <br><br>
            Are you registering as a business? <input type="checkbox" name="isBusiness"/>
        </form>
        </div>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
     </body>
</html>
