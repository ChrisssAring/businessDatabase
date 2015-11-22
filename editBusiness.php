<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (!array_key_exists("user", $_SESSION)) {
    header('Location: index.php');
    exit;
}

$stateIsNull = false;
$cityIsNull = false;
$workTypeIsNull = false;
$volunteerIsNull = false;


require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");
$businessID = BusinessDB::getInstance()->get_business_id_by_name($_SESSION['user']);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (array_key_exists("back", $_POST)) {
        header('Location: editBusinessInformation.php' ); 
        exit;
    } else {
        BusinessDB::getInstance()->update_business($_POST['businessID'], $_POST['ownerName'],
        $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postalCode'], $_POST['email'],
        $_POST['phoneFull'], $_POST['extension'], $_POST['website'], $_POST['goal'], $_POST['workType'],
        $_POST['positionsOpen'], $_POST['volunteer'], $_POST['hoursNeeded'], $_POST['beginMonth'],
        $_POST['endMonth'], $_POST['otherInformation']);
       header('Location: editBusinessInformation.php' );
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
        <?php 
        if  ($_SERVER["REQUEST_METHOD"] == "POST") {
            $phoneFull = BusinessDB::getInstance()->format_phone_for_sql($_POST["phoneFull"]);
            $area_code = $phoneFull[0];
            $extension_code = $phoneFull[1];
            $line_number = $phoneFull[2];
            $business = array("id" => $_POST["businessID"], "name" => $_POST["name"], 
            "owner_name" => $_POST["ownerName"], "address" => $_POST["address"], "city" => $_POST["city"], "state" => $_POST["state"],
            "postal_code" => $_POST["postalCode"], "email" => $_POST["email"], "area_code" => $area_code, "exchange_code" => $exchange_code,
            "line_number" => $line_number , "extension" => $_POST["extension"], "website" => $_POST["website"], "goal" => $_POST["goal"],
            "work_type" => $_POST["workType"], "positions_open" => $_POST["positionsOpen"], "volunteer" => $_POST["volunteer"], 
            "hours_needed" => $_POST["hoursNeeded"], "begin_month" => $_POST['beginMonth'], "end_month" => $_POST['endMonth'],
            "other_information" => $_POST["otherInformation"]);
        } else if (array_key_exists("businessID", $_GET)) {
            $business = mysqli_fetch_array(BusinessDB::getInstance()->get_businesses_by_business_id($_GET["businessID"]));
        } else {
            $business = array("owner_name" => "", "address" => "", "city" => "", "state" => "", "postal_code" => "", 
            "email" => "", "phoneFull" => "", "extension" => "", "website" => "", 
            "goal" => "", "work_type" => "", "positionsOpen" => "", "volunteer" => "", 
            "hours_needed" => "", "begin_month" => "", "end_month" => "", "other_information" => "");
        }
        ?>  
        <form name="editBusiness" action="editBusiness.php" method="POST">
            <input type="hidden" name="businessID" value="<?php echo $business["id"];?>" />
            Name of Owner: <input type="text" name="ownerName" value="<?php echo $business['owner_name'];?>"/><br/>
            Street Address: <input type="text" name="address" value="<?php echo $business['address'];?>"/><br/>
            City: <input type="text" name="city" value="<?php echo $business['city'];?>"/><br/>
            State: <input type="text" name="state" value="<?php echo $business['state'];?>"/><br/>
            ZIP Code: <input type="text" name="postalCode" value="<?php echo $business['postal_code'];?>"/><br/>
            Email: <input type="text" name="email" value="<?php echo $business['email'];?>"/><br/>
            Phone Number: <input type="text" name="phoneFull" value="<?php echo $business['area_code'].$business['exchange_code'].$business['line_number'] ;?>"/><br/>
            Extension Number: <input type="text" name="extension" value="<?php echo $business['extension'];?>"/><br/>
            Website: <input type="text" name="website" value="<?php echo $business['website'];?>"/><br/>
            Goal: <input type="text" name="goal" value="<?php echo $business['goal'];?>"/><br/>
            Work Type:<input type="text" name="workType" value="<?php echo $business['work_type'];?>"/><br/>
            Number of Available Positions: <input type="text" name="positionsOpen" value="<?php echo $business['positions_open'];?>"/><br/>
            Is Volunteer?: <input type="text" name="volunteer" value="<?php echo $business['volunteer'];?>"/><br/>
            Hours Needed: <input type="text" name="hoursNeeded" value="<?php echo $business['hours_needed'];?>"/><br/>
            <select name="beginMonth">
                <option value="January" <?php if($business['begin_month'] == 'January'){echo("selected");}?>>January</option>
                <option value="February" <?php if($business['begin_month'] == 'February'){echo("selected");}?>>February</option>
                <option value="March" <?php if($business['begin_month'] == 'March'){echo("selected");}?>>March</option>
                <option value="April" <?php if($business['begin_month'] == 'April'){echo("selected");}?>>April</option>
                <option value="May" <?php if($business['begin_month'] == 'May'){echo("selected");}?>>May</option>
                <option value="June" <?php if($business['begin_month'] == 'June'){echo("selected");}?>>June</option>
                <option value="July" <?php if($business['begin_month'] == 'July'){echo("selected");}?>>July</option>
                <option value="August" <?php if($business['begin_month'] == 'August'){echo("selected");}?>>August</option>
                <option value="September" <?php if($business['begin_month'] == 'September'){echo("selected");}?>>September</option>
                <option value="October" <?php if($business['begin_month'] == 'October'){echo("selected");}?>>October</option>
                <option value="November" <?php if($business['begin_month'] == 'November'){echo("selected");}?>>November</option>
                <option value="December" <?php if($business['begin_month'] == 'December'){echo("selected");}?>>December</option>
                </select>
                <select name="endMonth">
                <option value="January" <?php if($business['end_month'] == 'January'){echo("selected");}?>>January</option>
                <option value="February" <?php if($business['end_month'] == 'February'){echo("selected");}?>>February</option>
                <option value="March" <?php if($business['end_month'] == 'March'){echo("selected");}?>>March</option>
                <option value="April" <?php if($business['end_month'] == 'April'){echo("selected");}?>>April</option>
                <option value="May" <?php if($business['end_month'] == 'May'){echo("selected");}?>>May</option>
                <option value="June" <?php if($business['end_month'] == 'June'){echo("selected");}?>>June</option>
                <option value="July" <?php if($business['end_month'] == 'July'){echo("selected");}?>>July</option>
                <option value="August" <?php if($business['end_month'] == 'August'){echo("selected");}?>>August</option>
                <option value="September" <?php if($business['end_month'] == 'September'){echo("selected");}?>>September</option>
                <option value="October" <?php if($business['end_month'] == 'October'){echo("selected");}?>>October</option>
                <option value="November" <?php if($business['end_month'] == 'November'){echo("selected");}?>>November</option>
                <option value="December" <?php if($business['end_month'] == 'December'){echo("selected");}?>>December</option>
                </select>
            Other Information: <input type="text" name="otherInformation" value="<?php echo $business['other_information'];?>"/><br/>
            <input type="submit" name="saveBusinessInformation" value="Save Changes"/>
            <input type="submit" name="back" value="Back"/>
        </form>
    </body>
</html> 