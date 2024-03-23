


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
     <link rel="stylesheet" href="../css/propertylist.css">
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
                         <li><a href="profile.php">Profile</a><li>
                         <li><a href="addproperty.php">Add Property</a></li>
                         <li><a href="propertylist.php" class="active">List Property</a></li>
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
                    <h2>Property Listing</h2>
                    
                    <?php
                    // Include the database connection file
                    include 'connection.php';

                    // Fetching property lists from the database
                    $query = "SELECT * FROM property";
                    $result = mysqli_query($conn, $query);

                    // Check if there is any properties
                    if (mysqli_num_rows($result) > 0) {
        
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="product-list">';
                            
                            // Check if property image exists
                            if($row['propertyImg'] != '') {
                                echo '<img src="../propertyimg/' . $row['propertyImg'] . '" alt="home" class="property-img">';
                            }
                            
                            echo '<ul>';
                            echo '<li><img src="../images/icon-user.png" alt="user"><strong>Property Name: </strong>' . $row['propertyName'] . '</li>';
                            echo '<li><img src="../images/icon-home.png" alt="home"><strong>Property Type: </strong>' . $row['propertyType'] . '</li>';
                            echo '<li><img src="../images/icon-doller.png" alt="doller"><strong>Price: </strong>$ ' . $row['propertyPrice'] . '</li>';
                            echo '<li><img src="../images/icon-location.png" alt="location"><strong>Location: </strong>' . $row['propertyLocation'] . '</li>';
                            echo '</ul>';
                            echo '<p>' . $row['propertyDescription'] . '</p>';
                            echo '<a href="updateproperty.php?id=' . $row['propertyId'] . '" class="btn btn-success">Update</a>';
                            echo '<a href="deleteproperty.php?id=' . $row['propertyId'] . '&propertyimage=' . $row['propertyImg'] . '" class="btn btn-danger" style="margin-left: 10px;">Delete</a>';
                            
                            echo '</div>';
                        }
                    } else {
                        echo "can't find any property.";
                    }
                    ?>


                    <a href="#" class="load-btn">Load More</a>
                    <br>
                    <br>
                    <center><a href = "searchpage.php"><button id = "arrow-btn">></button></center>
                    <style>
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
        </div>
    </section>
 
    <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
 <script src="js/script.js" type="text/javascript"></script>
    </body>
</html>