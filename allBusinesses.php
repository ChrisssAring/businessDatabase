<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");

        $allBusinesses = BusinessDB::getInstance()->get_all_businesses($_POST['city'], $_POST['state'], $_POST['postalCode'], $_POST['workType'],
                $_POST['volunteer'], $_POST['hoursNeeded']);
        echo $_POST['city'];
        
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    
    <table border="black">
    <tr>
        <th>Name</th>
        <th>Owner</th>
        <th>Address</th>
        <th>Email Address</th>
        <th>Phone Number</th>
        <th>Website</th>
        <th>Goal</th>
        <th>Work Type</th>
        <th>Available Positions</th>
        <th>Is Volunteer Work?</th>
        <th>Hours Needed</th>
        <th>Beginning Month</th>
        <th>Ending Month</th>
        <th>Other Information</th>
    </tr>
    
    <?php
    while ($row = mysqli_fetch_array($allBusinesses)) {
        echo "<tr><td>" . htmlentities($row["name"]) . "</td>";
        echo "<td>" . htmlentities($row["owner_name"]) . "</td>";
        echo "<td>" . htmlentities($row[2]." ".$row[3]." ".$row[4]." ".$row[5]) . "</td>";
        echo "<td>" . htmlentities($row["email"]) . "</td>";
        echo "<td>" . htmlentities("(".$row[7].") ".$row[8]." - ".$row[9]." Ext. ".$row[10]) . "</td>";
        echo "<td>" . htmlentities($row["website"]) . "</td>";
        echo "<td>" . htmlentities($row["goal"]) . "</td>";
        echo "<td>" . htmlentities($row["work_type"]) . "</td>";
        echo "<td>" . htmlentities($row["positions_open"]) . "</td>";
        echo "<td>" . htmlentities($row["volunteer"]) . "</td>";
        echo "<td>" . htmlentities($row["hours_needed"]) . "</td>";
        echo "<td>" . htmlentities($row["begin_month"]) . "</td>";
        echo "<td>" . htmlentities($row["end_month"]) . "</td>";
        echo "<td>" . htmlentities($row["other_information"]) . "</td></tr>\n";
    } 
    mysqli_free_result($allBusinesses);
    ?>
    </table>    
</html>
