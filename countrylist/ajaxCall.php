<?php

// Database connection...
$hostCon = mysql_connect('localhost', 'root', ''); // Update your hosting details.
$dbCon = mysql_select_db('countrylist'); // Update your database name.

$location_id = $_POST["location_id"]; //Country ID
$locationType = $_POST["location_type"];

$types = array('country', 'State', 'City');

// Fire an query to get the al location of specific type...
$sql = "select * from location where location_type=" . $locationType . " and parent_id='" . $location_id . "'";
$result = mysql_query($sql);
if ($result) {
    while ($row = mysql_fetch_object($result)) {
        $obj[] = $row;
    }
}

// Now display all location in dorp down list...
echo '<option value="">Select '.$types[$locationType].'</option>';
foreach ($obj as $value) {
        echo "<option value='" . $value->location_id . "'>" . $value->name . "</option>";
}