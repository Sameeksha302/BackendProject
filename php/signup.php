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
                         <li><a href="signup.php" class="active">Sign Up</a></li>
                         <li><a href="login.php">Login</a></li>
                         <li><a href="profile.php">Profile</a><li>
                         <li><a href="addproperty.php">Add Property</a></li>
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
                    <h2>Sign Up</h2>
                   <form class="signup-form" method = "POST" action= "/test/php/signup.php" enctype="multipart/form-data">
                       <div class="wd70">
                      <div class="form-field">
                        <label>First Name*</label>
                          <input type="text" placeholder="Enter your First Name" name="firstName">
                     </div>
                         <div class="form-field">
                        <label>Last Name*</label>
                          <input type="text" placeholder="Enter your Last Name" name="lastName">
                     </div>
                       </div>
                       
                       <div class="wd30">
                       <div class="upload-picture">
                         <div class="fileUpload">
                          <input type="file" class="upload"  name="imageName"/>
                          </div>
                           <label>Upload Image</label>
                       </div>
                       </div>
                       
                         <div class="form-field">
                        <label>Email Address*</label>
                          <input type="email" placeholder="Enter your Email Address" name="email">
                     </div>
                         <div class="form-field">
                        <label>Password*</label>
                          <input type="password" placeholder="Enter Password" name="password">
                     </div>
                           <div class="form-field">
                        <label>Confirm Password*</label>
                          <input type="password" placeholder="Re-enter Password" name="cpassword">
                     </div>
                          <div class="form-field">
                        <label>Phone Number* </label>
                          <input type="number" placeholder="Enter your Phone Number" name="phoneNumber">
                     </div>
                       
                         <div class="form-field">
                        <label>Address* </label>
                          <textarea placeholder="Enter your Address" name="address"></textarea>
                     </div>
                       
                        <div class="form-field">
                           <input type="submit" value="Submit" name="signupSubmit"> 
                       </div>
                       
                       <p class="alredy-sign">Already Sign up <a href="/test/php/login.php"><u>Login Now</u></a></p>
                   </form>
                   </div>
                </div>
            </div>
        </div>
    </section>

    
    
    <script src="../js/jquery-3.5.1.min.js" type="/text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="/text/javascript"></script>
 <script src="../js/script.js" type="/text/javascript"></script>


 
    </body>
</html>





<?php
include 'connection.php';

$error = true;
$firstName = "";
$lastName = "";
$email = "";
$pass = "";
$cpass = "";
$phoneNumber = "";
$address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName =  trim($_POST["firstName"]);
    $lastName =  trim($_POST["lastName"]);
    $email =  trim($_POST["email"]);
    $pass =  trim($_POST["password"]);
    $cpass =  trim($_POST["cpassword"]);
    $phoneNumber = trim($_POST['phoneNumber']);
    $address = trim($_POST['address']);

    // validation for empty fields
    if ($pass != $cpass) {
        echo '<script>alert("Password and confirm password should be same")</script>';
        $error = false;
    }

    if (empty($firstName) || empty($lastName) || empty($email) || empty($pass) || empty($cpass)||empty($phoneNumber) || empty($address)||empty($_FILES["imageName"]["name"])) {
        echo '<script>alert("Please fill all required fields")</script>';
        $error = false;
    }

    //saving user details in database
    if ($error == true) {
        //if any file is not uploaded by user
        if ($_FILES["imageName"]["name"] == "") {
            $insertsql = "INSERT INTO users (firstName, lastName, email, password, phoneNumber, address) VALUES ('$firstName', '$lastName', '$email', '$pass', '$phoneNumber', '$address')";

            if (mysqli_query($conn, $insertsql)) {
                echo '<script>window.location.href = "../php/login.php";</script>';
            } else {
                echo "Error in data insertion : ".mysqli_error($conn);
                $error = false;
            }
        } else {
            $filename = basename($_FILES["imageName"]["name"]);
            $tempname = $_FILES["imageName"]["tmp_name"];
            $targetDir = "../userimage/" . $filename;

            if (move_uploaded_file($tempname, $targetDir)) {
                $insertQuery = "INSERT INTO users (firstName, lastName, imgpath, email, password, phoneNumber, address) VALUES ('$firstName', '$lastName', '$filename', '$email', '$pass', '$phoneNumber', '$address')";

                if (mysqli_query($conn, $insertQuery)) {
                    echo '<script>window.location.href = "../php/login.php";</script>';
                } else {
                    $file_path = $targetDir . $filename;
                    // If file is uploaded but user details is not saved then deleting uploaded file
                    if (file_exists($file_path)) {
                        if (unlink($file_path)) {
                            echo "File get deleted successfully.";
                        } else {
                            echo "Error in deleting file.";
                        }
                    }
                    echo "Error in data insertion : ". mysqli_error($conn);
                }
            }
        }
    } 
}
?>