<?php
$username  = "root";
$password = "";
$server = "localhost:3308";
$db = "test";

$conn = new mysqli($server,$username,$password,$db);
if($conn->connect_error)
{
    die("Connection Failed : ".$conn->connect_error);
}
else{
  // echo "Successfully Connected";
}

?>
