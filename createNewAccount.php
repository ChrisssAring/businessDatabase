<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("C:\\xampp\\htdocs\\BusinessDatabase\\Includes\\dp.php");
require_once ("C:\\xampp\\php\\pear\\Mail.php");

/** other variables */
$businessNameIsUnique = true;
$userNameIsUnique = true;
$UserAccountEmailIsUnique = true;
$BusinessAccountEmailIsUnique = true;
$passwordIsValid = true;				
$userIsEmpty = false;
$accountEmailIsValid = true;
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
    
    if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['accountEmail'])){
        $accountEmailIsValid = false;
    } else {
        $email = $_POST["accountEmail"];
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
    
    if (!$userIsEmpty && $userNameIsUnique && $accountEmailIsValid && $businessNameIsUnique && $BusinessAccountEmailIsUnique && $UserAccountEmailIsUnique && !$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        $hash = md5(rand(0,1000));
        if (isset($_POST['isBusiness'])) {
            BusinessDB::getInstance()->create_business($_POST["user"], $email, $_POST["password"], $hash);
            $link = "verifyBusiness.php?email=";
            echo $link;
            
        } else if (!isset($_POST['isBusiness'])) {
            echo $email;
          
            BusinessDB::getInstance()->create_user($_POST["user"], $email, $_POST["password"], $hash);
            $link = "verifyUser.php?email=";
            echo $link;
            
        }
        echo $email;
 $from = "Earthbird <earthbird@example.com>";
 $to = $email;
 $subject = "Earthbird Verification";
 $body =  '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$_POST['user'].'
Password: '.$_POST['password'].'
------------------------
 
Please click this link to activate your account:
http://localhost/BusinessDatabase/' . $link . $email.'&hash='.$hash.'
 
'; // Our message above including the link
                     
 $host = "ssl://smtp.gmail.com";
 $port = "465";
 $username = "chrisssaring@gmail.com";
 $password = "chrisrocks2468";

 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));

 $mail = $smtp->send($to, $headers, $body);

 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }
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
                if ($userIsEmpty) {
                    echo "Please enter a usename.";
                }
            }
            ?>
            </p>
            <input type="email" placeholder="Email" name="accountEmail" /><br>
            <p class="error">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                if (!$UserAccountEmailIsUnique || !$BusinessAccountEmailIsUnique) {
                    echo "That email account is already in use.";
                }
                 if ($accountEmailIsEmpty) {
                    echo "Please enter an email.";
                }
                if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['accountEmail'])){
                    echo "Please enter a valid email.";
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
