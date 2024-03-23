<?php
session_start();
include 'connection.php';

if(isset($_SESSION['email']) == null){
    echo('<script>alert("Do login first")</script>');
    echo '<script>window.location.href = "../php/login.php";</script>';
    exit();
}
$error = true;

$firstName = "";
$lastName = "";
$email = $_SESSION['email'] ;
$password = "";
$cpassword = "";
$phoneNumber = "";
$address = "";
$image = "";


$query = "SELECT * FROM users where email = '$email'";

$result  = mysqli_query($conn,$query);


if($result){
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $email = $row['email'];
        $password = $row['password'];
        $phoneNumber = $row['phoneNumber'];
        $address = $row['address'];
        $image = $row['imgpath'];
        //echo($image);

    }
}else{
    echo "Error in fetching user details: " . mysqli_error($conn);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName =  trim($_POST["firstName"]);
    $lastName =  trim($_POST["lastName"]);
    $newEmail =  trim($_POST["email"]);
    $password =  trim($_POST["password"]);
    $cpassword =  trim($_POST["npassword"]);
    $ncpassword =  trim($_POST["ncpassword"]);
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];

    //validation for empty fields
    if (isset($ncpassword) && isset($cpassword) && $ncpassword != $cpassword) {
        echo '<script>alert("Password and Confirm password should be same")</script>';
        $error = false;
    }
    
        // saving user details in database
        if ($error == true) {
            // If any file is not get uploaded
            $updatesql;
            if ($_FILES["imageName"]["name"] == "") {
                if(isset($ncpassword)){

                    $updatesql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', phoneNumber = '$phoneNumber',address = '$address',email = '$newEmail', password = '$ncpassword' WHERE email = '$email';";
                }
                else {
                    $updatesql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', phoneNumber = '$phoneNumber',address = '$address',email = '$newEmail'  WHERE email = '$email';";
                    
                }
                if (mysqli_query($conn, $updatesql)) {
                    echo '<script>window.location.href = "../php/profile.php";</script>';
                } else {
                    echo "Error in saving user details in database : " . mysqli_error($conn);
                }
            } 
            else {
               
                $filename = basename($_FILES["imageName"]["name"]);
                $tempname = $_FILES["imageName"]["tmp_name"];
                $targetDir = "../userimage/".$filename;
                
                if (move_uploaded_file($tempname, $targetDir)) {
                    if(isset($ncpassword)){
                        $updatesql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', phoneNumber = '$phoneNumber', imgpath = '$filename',address = '$address',email = '$newEmail', password = '$ncpassword' WHERE email = '$email';";
                    }
                    else {
                        $updatesql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', phoneNumber = '$phoneNumber', imgpath = '$filename',address = '$address',email = '$newEmail'  WHERE email = '$email';";
                        
                    }
                    
                    if (mysqli_query($conn, $updatesql))
                    { // removing previously saved file before updating        
                        $file_path = $targetDir.$image;
                        if (file_exists($file_path)) 
                        {
                            if (unlink($file_path)) {
                               echo "File get deleted successfully.";
                            }
                            else {
                               echo "Error in deleting file.";
                            }
                        }

                    } 
                    else{
                        // If file is uploaded but user details is not saved in db then deleting uploaded file
                        $file_path = $targetDir.$filename;
                        if (file_exists($file_path)) {
                            if (unlink($file_path)) {
                                echo "File get deleted successfully.";
                            } else {
                                echo "Error in deleting file.";
                            }
                        }
                        echo "Error in updating record: " . mysqli_error($conn);
                    }
                }
            }
        } 
        echo '<script>window.location.href = "../php/profile.php";</script>';

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
     <link rel="stylesheet" href="../css/profile.css">
     <script src="../js/profile.js"></script>
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
                         <li><a href="profile.php" class="active">Profile</a></li>
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
                    <h2>profile</h2>
                   <form class="signup-form" method = "POST" action= "/test/php/profile.php" enctype="multipart/form-data">
                       <div class="wd70">
                      <div class="form-field">
                        <label>First Name*</label>
                          <input type="text" placeholder="Enter your First Name" name="firstName" value="<?php echo $firstName;?>" disabled>
                     </div>
                         <div class="form-field">
                        <label>Last Name*</label>
                          <input type="text" placeholder="Enter your Last Name" name="lastName"  value="<?php echo $lastName;?>" disabled>
                     </div>
                       </div>
                       
                       <div class="wd30">
                       <div class="upload-picture">
                         <div class="fileUpload">
                            
                        <img src="../userimage/<?php echo $image;?>" alt="" srcset="" class="form-field" class="upload" id="img">
                       
                             <input type="file" class="upload"  name="imageName"    />
                          
                        </div>
                       
                       </div>
                       </div>
                       
                         <div class="form-field">
                        <label>Email Address*</label>
                          <input type="email" placeholder="Enter your Email Address" name="email" value="<?php echo $email; ?>"  disabled>
                     </div>
                     <button type="button" onclick="passwords()" id="change-btn">change password</button>
                     <div id="new-pass-div">
                         <div class="form-field">
                        <label>Password*</label>
                          <input type="password" placeholder="Enter Password" name="password" >
                     </div>
                            <div class="form-field">
                                <label>New  Password*</label>
                                  <input type="password" placeholder="Re-enter Password" name="npassword">
                                  <div class="form-field">
                                    <label>Confirm New Password*</label>
                                    <input type="password" placeholder="Re-enter new Password" name="ncpassword" >
                                  </div>
                            </div>
                     </div>
                          <div class="form-field">
                        <label>Phone Number* </label>
                          <input type="number" placeholder="Enter your Phone Number" name="phoneNumber" value="<?php echo $phoneNumber; ?>"  disabled>
                     </div>
                       
                         <div class="form-field">
                        <label>Address* </label>
                          <textarea placeholder="Enter your Address" name="address"  <?php echo $address; ?>  id="myTextarea"disabled><?php echo $address; ?></textarea>
                     </div>
                       
                        <div class="form-field">
                            <input type="submit" value="Submit" name="signupSubmit" id="submit-btn"   class="hidden" disabled> 
                        </div>
                        
                        
                    </form>
                </div>
                <center><button id="update-btn" class="hidden"  onclick="displaySubmit()">update profile</button>

                <a href="logout.php"><button id="log-btn">Logout</button></center></a>
                <br>
                <center><a href = "addproperty.php"><button id = "arrow-btn">></button></center>
                <style>
                  #log-btn
                  {
                    background-color: #e85625;              
                    padding: 10px 18px; 
                    color: white;      
                    border: none;              /* Remove default border */
                    border-radius: 5px;        /* Rounded corners */
                    font-size: 16px;           
                    font-weight: bold;        
                    text-align: center;        
                    cursor: pointer;          
                    transition: all 0.2s ease-in-out; 
                }
                #log-btn:hover{
                    background-color: #760907;  
                } 
                
                #arrow-btn{
                    background-color: #007bff; 
                    color: #fff;
                    padding: 5px 18px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    bottom: 20px;
                    right: 10px;
                    justify-content: flex-end;
                    margin-left: auto;
                    
                }
  
                #arrow-btn:hover {
                    background-color: #0062cc; /* Change background color on hover (optional) */
                }
                    
                </style>
            </div>
            </div>
        </div>
    </section>

    
    
    <script src="../js/jquery-3.5.1.min.js" type="/text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="/text/javascript"></script>
 <script src="../js/script.js" type="/text/javascript"></script>


 
    </body>
</html>



