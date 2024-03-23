
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
                         <li><a href="login.php" class="active">Login</a></li>
                         <li><a href="profile.php">Profile</a></li>
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
                    <h2>Login</h2>
                   <form class="login-form" method="post"  action="/test/php/login.php">
                       
                         <div class="form-field">
                        <label>Email Address*</label>
                          <input type="email" placeholder="Enter your Email Address" name="email">
                     </div>
                         <div class="form-field">
                        <label>Password*</label>
                          <input type="password" placeholder="Enter Password" name="password">
                              <div class="formcheck">
                          <input type="checkbox" id="remember" checked>
                           <label for="remember">Remember me</label>
                       </div>
                             <a href="#" class="forgetpwd">forget password?</a>
                     </div>
                      
                        <div class="form-field">
                           <input type="submit" value="Login"> 
                       </div>
                       
                       <p class="alredy-sign">Sign up <a href="/test/php/signup.php"><u> Now</u></a></p>
                   </form>
                   </div>
                </div>
            </div>
        </div>
    </section>

    
    
    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
 <script src="js/script.js" type="text/javascript"></script>
    </body>
</html>





<?php
session_start();
include 'connection.php';

$email = "";
$pass = "";
$error = true;
$result;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email =  trim($_POST["email"]);
    $pass =  trim($_POST["password"]);
  

    //validation over empty fields
  
     if (empty($email)) {
        echo '<script>alert("Enter email ID")</script>';
        $error = false;
    } else if (empty($pass)) {
        echo '<script>alert("Enter password")</script>';
        $error = false;
    }

    // backend for login 
    if ($error == true) {
       
         
        $loginsql = "SELECT email ,password FROM users WHERE email = '$email'";
            
            $result = mysqli_query($conn, $loginsql);
          
            if ($result) {
                $dbResult = mysqli_fetch_assoc($result);
                if ($dbResult) {
                    $dbpass = $dbResult["password"];

                    if($dbpass == $pass){
                        $_SESSION['email'] = $email;
                        echo ($_SESSION['email']);
                        echo '<script>window.location.href = "../php/profile.php";</script>';

                    }
                    else{
                        echo '<script>alert("Invalid password")</script>';
                    }
                    
                } else {
                    echo '<script>alert("User not found or may be you incorrected email")</script>';
                }
            } else {
                echo "Error in finding user login detail " . mysqli_error($conn);
            }
           
         
    } 
}
?>