<?php
//print_r($_POST); //AID
include "dbconnect.php";
session_start();
$U_ID = $_SESSION['User'];
$emps = json_decode($_POST['emp'],true);
$timestamp = date('Y-m-d H:i:s');

//print_r($emps);

//foreach($emps as $emp)
//{
    $lat = $emps['latitude'];
    $lng = $emps['longitude'];
    $result = mysqli_query($conn,"UPDATE user SET Latitude = '$lat' , Longitude = '$lng', Timestamp='$timestamp' WHERE Email_ID = '$U_ID'");
//}
//echo "Done";
?>
