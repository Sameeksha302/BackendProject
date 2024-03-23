<?php

session_start();
include 'connection.php';
$error = true;
$propertyName = "";
$propertyType = "";
$propertyPrice = "";
$propertyLocation = "";
$propertyDescription = "";



if (isset($_SESSION['email'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $propertyName = trim($_POST["propertyName"]);
        $propertyType = trim($_POST["propertyType"]);
        $propertyPrice = trim($_POST["propertyPrice"]);
        $propertyLocation = trim($_POST["propertyLocation"]);
        $propertyDescription = trim($_POST["propertyDescription"]);

        //validating empty field

        if (empty($propertyName)||empty($propertyType)||empty($propertyLocation)||empty($propertyDescription)||empty($propertyPrice)||$_FILES["propertyImg"]["name"] == "") {
            echo '<script>alert("Please fill all the required fields")</script>';
            $error = false;
        }

        //saving the property details
        if ($error == true) {
            // If any file is not get uploaded
            if ($_FILES["propertyImg"]["name"] == "") {
                $insertsql = "INSERT INTO property (propertyName, propertyType, propertyPrice, propertyLocation, propertyDescription) VALUES ('$propertyName', '$propertyType', '$propertyPrice', '$propertyLocation', '$propertyDescription')";

                if (mysqli_query($conn, $insertsql)) {
                    echo '<script>window.location.href = "../php/propertylist.php";</script>';
                    exit(); 
                } else {
                    echo "Error in inserting property details: " . mysqli_error($conn);
                }
            } else {
                $filename = basename($_FILES["propertyImg"]["name"]);
                $tempname = $_FILES["propertyImg"]["tmp_name"];
                $targetDir = "../propertyimg/" . $filename;

                // Checking for file upload errors
                if ($_FILES["propertyImg"]["error"] != UPLOAD_ERR_OK) {
                    echo "File upload error: " . $_FILES["propertyImg"]["error"];
                    exit();
                }

                if (move_uploaded_file($tempname, $targetDir)) {
                    $insertsql = "INSERT INTO property (propertyName, propertyType, propertyPrice, propertyLocation, propertyDescription, propertyImg) VALUES ('$propertyName', '$propertyType', '$propertyPrice', '$propertyLocation', '$propertyDescription', '$filename')";
                    if (mysqli_query($conn, $insertsql)) {
                        echo '<script>window.location.href = "../php/propertylist.php";</script>';
                        exit(); 
                    } else {
                        $file_path = $targetDir . $filename;
                        // If file is uploaded but property details are not saved then deleting uploaded file
                        if (file_exists($file_path)) {
                            if (unlink($file_path)) {
                                echo "File get deleted successfully.";
                            } else {
                                echo "Error in deleting file image.";
                            }
                        }
                        echo "Error in inserting property details: " . mysqli_error($conn);
                    }
                }
            }
        }
    }
}
else {
    // if session is not setted go to the login page
    echo '<script>alert("Do login first")</script>';
    echo '<script>window.location.href = "../php/login.php";</script>';
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codingkart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
     <link href="../css/font-awesome.min.css" type="text/css" rel="stylesheet">
     <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="../css/global_fonts_style.css" type="text/css" rel="stylesheet">
     <link href="../css/style.css" type="text/css" rel="stylesheet">
     <link href="../css/responsive.css" type="text/css" rel="stylesheet">
</head>
<body>
    
    
    <section class="main-banner">
        <div class="container">
            <div class="row">
               <div class="col-md-12">
                   <h1>Codingkart Test</h1>
                </div>
            </div>
        </div>
    </section>
    
    <section class="nav-banner">
           <div class="container">
            <div class="row">
               <div class="col-md-12">
                   <div class="navs">
                   <ul>
                        <li><a href="signup.php">Sign Up</a></li>
                         <li><a href="login.php">Login</a></li>
                         <li><a href ="profile.php">Profile</a><li>
                         <li><a href="addproperty.php"  class="active">Add Property</a></li>
                         <li><a href="propertylist.php">List Property</a></li>
                         <li><a href="searchpage.php">Search Property</a></li>
                     </ul>
                       
                        <a href="#" class="mobile-icon"><i class="fa fa-bars" aria-hidden="true"></i></a>
                       
                   </div>
                </div>
               </div>
        </div>
    </section>
    
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
               <div class="col-md-12">
                   <div class="main-width">
                    <h2>Add Property Form</h2>
                   <form class="Property-form" method="POST"  action='/test/php/addproperty.php' enctype="multipart/form-data">
                       <div class="wd70">
                      <div class="form-field">
                        <label>Property Name*</label>
                          <input type="text" placeholder="Enter Property Name" name = "propertyName">
                     </div>
                         <div class="form-field">
                        <label>Property Type*</label>
                          <select name="propertyType">
                              <option value="">Property Type</option>
                              <option value="Rent">Rent</option>
                              <option value="Sell">Sell</option>
                                
                          </select>
                     </div>
                       </div>
                       
                       <div class="wd30">
                       <div class="upload-picture">
                         <div class="fileUpload">
                          <input type="file" class="upload" name="propertyImg" />
                          </div>
                           <label>Property Image</label>
                       </div>
                       </div>
                       
                         <div class="form-field">
                        <label>Property Price*</label>
                          <input type="number" placeholder="Enter Property Price" name="propertyPrice">
                     </div>
                         <div class="form-field">
                        <label>Property Location*</label>
                          <input type="text" placeholder="Enter Location"  name="propertyLocation">
                     </div>
                         
                          
                         <div class="form-field">
                        <label>Property Description* </label>
                          <textarea placeholder="Enter Description"  name="propertyDescription"></textarea>
                     </div>
                       
                        <div class="form-field">
                           <input type="submit" value="Submit"> 
                       </div>
                   </form>
                   </div>
                </div>
            </div>
        </div>
    </section>

    
    
    <script src="../js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
 <script src="../js/script.js" type="text/javascript"></script>
    </body>
</html>



