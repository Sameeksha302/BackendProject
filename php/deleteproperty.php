<?php
session_start();
error_reporting(0);
include 'connection.php';
if (isset($_SESSION['email'])) {
    if(isset($_GET['id'])){
    $propertyId = $_GET['id'];
    $deletesql = "DELETE FROM property WHERE propertyId='$propertyId'";
    if (mysqli_query($conn, $deletesql)) {
        $propertyimage = $_GET['propertyimage'];
        $tempname = $_FILES["imgName"]["tmp_name"];
        $targetDir = "../propertyimg/" . $propertyimage;
        $file_path = $targetDir . $filename;
                    // deleting the uploaded file of property
                    if (file_exists($file_path)) {
                        if (unlink($file_path)) {
                            echo "File gets deleted successfully!";
                        } else {
                            echo "Error found in deleting file!!!";
                        }
                    }
        echo '<script>window.location.href = "../php/propertylist.php";</script>';
        exit();
    } else {
        echo "Error in deleting the property details: " . mysqli_error($conn);
    }
 }
}
else{
    echo '<script>alert("Do login first")</script>';
    echo '<script>window.location.href = "../php/login.php";</script>';
    exit(); 
}

?>