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
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="businessList.php">
            Enter a Business: <input type="text" name="business" value="" />
            <input type="submit" value="Go" />
        </form>
        
        <form name="searchBusiness" action="allBusinesses.php" method="POST">
            City: <input type="text" name="city" value=""/><br/>
            State: <input type="text" name="state" value=""/><br/>
            ZIP Code: <input type="text" name="postalCode" value=""/><br/>
            Work Type:<input type="text" name="workType" value=""/><br/>
            Is Volunteer?: <input type="text" name="volunteer" value=""/><br/>
            Hours Needed: <input type="text" name="hoursNeeded" value=""/><br/>
            <select name="beginMonth">
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December"></option>
                </select>
                <select name="endMonth">
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December"></option>
                </select>
            <input type="submit" name="searchBusinesses" value="Search!"/>
            <input type="submit" name="back" value="Back"/>
        </form>
        
    </body>
</html>
