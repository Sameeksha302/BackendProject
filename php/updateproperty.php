<?php

session_start();

include 'connection.php';
$error = true;
$propertyName = "";
$propertyType = "";
$propertyPrice = "";
$propertyLocation = "";
$propertyDescription = "";
$propertyImg = "";
$propertyId ="";


if(isset($_SESSION['email']))
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $propertyId = $_GET['id'];
    $query = "SELECT * FROM property WHERE propertyId = '$propertyId'";
    $result = mysqli_query($conn, $query);

    if($result){
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $propertyName = $row['propertyName'];
            $propertyType = $row['propertyType'];
            $propertyPrice = $row['propertyPrice'];
            $propertyLocation = $row['propertyLocation'];
            $propertyDescription = $row['propertyDescription'];
            $propertyImg = $row['propertyImg'];
        }
    } else {
        echo "Error in fetching property details: " . mysqli_error($conn);
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $propertyName = trim($_POST["propertyName"]);
        $propertyType = trim($_POST["propertyType"]);
        $propertyPrice = trim($_POST["propertyPrice"]);
        $propertyLocation = trim($_POST["propertyLocation"]);
        $propertyDescription = trim($_POST["propertyDescription"]);
        $propertyId = trim($_POST["propertyId"]);
        $old_img = trim($_POST["oldimg"]);
        
        // saving property details
        if ($error == true) {
            // If any file is not get uploaded
            if ($_FILES["propertyImg"]["name"] == "") {
               
                $updatesql = "UPDATE property SET propertyName='$propertyName', propertyType='$propertyType', propertyPrice='$propertyPrice', propertyLocation='$propertyLocation', propertyDescription='$propertyDescription' WHERE propertyId='$propertyId'";

                if (mysqli_query($conn, $updatesql)) {
                    echo '<script>window.location.href = "../php/propertylist.php";</script>';
                    exit(); 
                } else {
                    echo "Error in updating details: " . mysqli_error($conn);
                }
            }  
            else {
                $filename = basename($_FILES["propertyImg"]["name"]);
                $tempname = $_FILES["propertyImg"]["tmp_name"];
                $targetDir = "../propertyimg/" . $filename;

                // Check for file upload errors
                if ($_FILES["propertyImg"]["error"] != UPLOAD_ERR_OK) {
                    echo "File upload error: " . $_FILES["propertyImg"]["error"];
                    exit();
                }

                //deleting previous image from saving folder if image exists
                if($old_img != "")
                {
                    $currentImagePath ="../propertyimg/".$old_img;
                    if(file_exists($currentImagePath))
                    {
                        if(unlink($currentImagePath))
                        {
                            echo "Current image deleted successfully";
                        }
                        else{
                            echo "Error in deleting current image!!";
                        }
                    }
                }
                if (move_uploaded_file($tempname, $targetDir)) {
                   
                    
                    $updatesql = "UPDATE property SET propertyName='$propertyName', propertyType='$propertyType', propertyPrice='$propertyPrice', propertyLocation='$propertyLocation', propertyDescription='$propertyDescription',propertyImg = '$filename' WHERE propertyId='$propertyId'";

                    if (mysqli_query($conn, $updatesql)) {
                        echo '<script>window.location.href = "../php/propertylist.php";</script>';
                        exit();
                    } else {
                        echo "Error in updating property details in database: " . mysqli_error($conn);
                    }
                }
                else{
                    echo "Error in uploading file!!";
                }
            }
        }
    }
}
else{
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
    <script src="../js/updateproperty.js"></script>
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
                        <li><a href="signup.php" >Sign Up</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="profile.php">Profile</a><li>
                        <li><a href="addproperty.php">Add Property</a></li>
                        <li><a href="propertylist.php">List Property</a></li>
                        <li><a href="updateproperty.php" class = "active">Update Property</a></li>
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
                    <h2>Property Form</h2>
                    <form class="Property-form" method="POST"  action='/test/php/updateproperty.php' enctype="multipart/form-data">
                        <div class="wd70">
                            <div class="form-field">
                                <label>Property Name*</label>
                                <input type="number"  name="propertyId" class = "hidden"value="<?php echo $propertyId; ?>" >
                                <input type="text" placeholder="Enter Property Name" name="propertyName" value="<?php echo $propertyName; ?>">
                            </div>
                            <div class="form-field">
                                <label>Property Type*</label>
                                <select name="propertyType">
                                    <option value="">Property Type</option>
                                    <option value="Rent" <?php if($propertyType == 'Rent') echo 'selected'; ?>>Rent</option>
                                    <option value="Sell" <?php if($propertyType == 'Sell') echo 'selected'; ?>>Sell</option>
                                </select>
                            </div>
                        </div>

                        <div class="wd30">
                        <div class="upload-picture">
                            <label for="file-upload" id="file-upload-label">Property Image</label>
                            <div class="fileUpload" style="position: relative;">
                                <input type="file" id="file-upload" class="upload" name="propertyImg" style="display: none;" onchange="displayImg(event)" />
                            <?php if($propertyImg != '') echo '<img src="../propertyimg/'.$propertyImg.'" alt="property image" class="property-img" style="max-width: 100%; height: auto; position: absolute; top: 0; left: 0;" onclick="document.getElementById(\'file-upload\').click();">'; ?>
                        </div>
                    </div>
                        </div>

                        <div class="form-field">
                            <label>Property Price*</label>
                            <input type="number" placeholder="Enter Property Price" name="propertyPrice" value="<?php echo $propertyPrice; ?>">
                        </div>
                        <div class="form-field">
                            <label>Property Location*</label>
                            <input type="text" placeholder="Enter Location"  name="propertyLocation" value="<?php echo $propertyLocation; ?>">
                        </div>

                        <div class="form-field">
                            <label>Property Description* </label>
                            <textarea placeholder="Enter Description"  name="propertyDescription"><?php echo $propertyDescription; ?></textarea>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $propertyId; ?>">

                        <div class="form-field">
                            <input type="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hidden{
        display:none;
    }
</style>

<script src="../js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
</body>
</html>
