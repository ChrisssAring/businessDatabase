<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Business of: <?php echo htmlentities($_GET["business"])."<br/>";?>
        <?php
        require_once("C:\\xampp\\htdocs\\BusinessInformation\\Includes\\dp.php");
        $businessID = BusinessDB::getInstance()-> get_business_id_by_name ($_GET["business"]);
        if (!$businessID) {
            exit("The business " .$_GET["business"]. " can not be found. Please check the spelling and try again" );
        }
        ?>
    </body>
    
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
        <th>Compensated Experience</th>
        <th>Hours Needed</th>
        <th>Beginning Month</th>
        <th>Ending Month</th>
        <th>Other Information</th>
    </tr>
    
    <?php
    $result = BusinessDB::getInstance()->get_businesses_by_business_id($businessID);
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td>" . htmlentities($row["name"]) . "</td>";
        echo "<td>" . htmlentities($row["owner_name"]) . "</td>";
        echo "<td>" . htmlentities($row[2]." ".$row[3]." ".$row[4]." ".$row[5]) . "</td>";
        echo "<td>" . htmlentities($row["email"]) . "</td>";
        echo "<td>" . htmlentities("(".$row[7].") ".$row[8]." - ".$row[9]." Ext. ".$row[10]) . "</td>";
        echo "<td>" . htmlentities($row["website"]) . "</td>";
        echo "<td>" . htmlentities($row["goal"]) . "</td>";
        echo "<td>" . htmlentities($row["work_type"]) . "</td>";
        echo "<td>" . htmlentities($row["positions_open"]) . "</td>";
        echo "<td>" . htmlentities($row["compensated_experience"]) . "</td>";
        echo "<td>" . htmlentities($row["hours_needed"]) . "</td>";
        echo "<td>" . htmlentities($row["begin_month"]) . "</td>";
        echo "<td>" . htmlentities($row["end_month"]) . "</td>";
        echo "<td>" . htmlentities($row["other_information"]) . "</td></tr>\n";
    } 
    mysqli_free_result($result);
    ?>
    </table>    
</html>