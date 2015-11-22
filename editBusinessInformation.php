<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        if (array_key_exists("user", $_SESSION)) {
            echo "Hello " . $_SESSION['user'];
        } else {
            header('Location: index.php');
            exit;
        }
        ?>
    <table border="black">
    <tr><th>Name</th>
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
        <th>Other Information</th></tr>
    <?php
    
    require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");
    $businessID = BusinessDB::getInstance()->get_business_id_by_name($_SESSION["user"]);
    $result = BusinessDB::getInstance()->get_businesses_by_business_id($businessID);
    while ($row = mysqli_fetch_array($result)) :
        echo "<tr><td>" . htmlentities($row["name"]) . "</td>";
        echo "<td>" . htmlentities($row["owner_name"]) . "</td>";
        echo "<td>" . htmlentities($row[3]." ".$row[4]." ".$row[5]." ".$row[6]) . "</td>";
        echo "<td>" . htmlentities($row["email"]) . "</td>";
        echo "<td>" . htmlentities("(".$row[8].") - ".$row[9]." - ".$row[10]." Ext. ".$row[11]) . "</td>";
        echo "<td>" . htmlentities($row["website"]) . "</td>";
        echo "<td>" . htmlentities($row["goal"]) . "</td>";
        echo "<td>" . htmlentities($row["work_type"]) . "</td>";
        echo "<td>" . htmlentities($row["positions_open"]) . "</td>";
        echo "<td>" . htmlentities($row["volunteer"]) . "</td>";
        echo "<td>" . htmlentities($row["hours_needed"]) . "</td>";
        echo "<td>" . htmlentities($row["begin_month"]) . "</td>";
        echo "<td>" . htmlentities($row["end_month"]) . "</td>";
        echo "<td>" . htmlentities($row["other_information"]) . "</td>";
        $businessID = $row["id"];
    ?>
    <td>
        <form name="editBusiness" action="editBusiness.php" method="GET">
            <input type="hidden" name="businessID" value="<?php echo $businessID; ?>">
            <input type="submit" name="editBusiness" value="Edit">
        </form>
    </td>
    <?php
    "</tr>\n";
    endwhile;
    mysqli_free_result($result);
    ?>       
    </table>
<!--    <form name="addNewBusiness" action="editBusiness.php">            
        <input type="submit" value="Add Wish">
    </form>-->
    <form name="backToMainPage" action="index.php">
        <input type="submit" value="Back To Main Page"/>
    </form>
    </body>
</html>
