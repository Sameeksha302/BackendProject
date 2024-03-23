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
                         <li><a href="propertylist.php">List Property</a></li>
                         <li><a href="searchpage.php" class="active">Search Property</a></li>
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
                    <h2>Property Searching</h2>
                   <form class="search-form">
                      <div class="form-field width50">
                        <label>Property Name</label>
                          <input type="text" placeholder="Search by property name" name="propertyName">
                     </div>
                     <div class="form-field width50">
                        <label>Property Type</label>
                          <select name="propertyType"> 
                              <option value="property-type" >Search by Property Type</option> 
                              <option value="Rent">Rent</option>
                              <option value="Sell">Sell</option>  
                          </select>
                     </div>
                     <div class="form-field width50">
                          <label>Enter minimum price range</label>
                          <input type="number" name="minprice" placeholder="Enter minimum price range">
                     </div>
                     <div class="form-field width50">
                          <label>Enter maximum price range</label>
                          <input type="number"  name="maxprice" placeholder="Enter maximum price range">
                     </div>
                     <div class="form-field">
                        <label>Property Location</label>
                          <input type="text"  name="propertyLocation" placeholder="Search by location" name>
                     </div>
                     <div class="form-field">
                         <input type="submit" value="Search"> 
                     </div>
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
include 'connection.php';
error_reporting(0);


$searchName = mysqli_real_escape_string($conn, trim($_GET['propertyName']));
$searchtype = mysqli_real_escape_string($conn, trim($_GET['propertyType']));
$minprice = $_GET['minprice'];
$maxprice = $_GET['maxprice'];
$searchLocation = mysqli_real_escape_string($conn, trim($_GET['propertyLocation']));

$sql = "SELECT * FROM property WHERE 1";

if (!empty($searchName)) {
    $sql .= " AND propertyName LIKE '$searchName'";
}

if (!empty($searchtype) && $searchtype != "property-type") {
    $sql .= " AND propertyType = '$searchtype'";
}

if (!empty($minprice)) {
    $sql .= " AND propertyPrice >= $minprice";
}

if (!empty($maxprice)) {
    $sql .= " AND propertyPrice <= $maxprice";
}

if (!empty($searchLocation)) {
    $sql .= " AND propertyLocation LIKE '%$searchLocation%'";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-list">';
        echo '<img src="../propertyimg/' . $row['propertyImg'] . '" alt="home" class="property-img">';
        echo '<ul>';
        echo '<li><img src="../images/icon-user.png" alt="user"><strong>Property Name: </strong>' . $row['propertyName'] . '</li>';
        echo '<li><img src="../images/icon-home.png" alt="home"><strong>Property Type: </strong>' . $row['propertyType'] . '</li>';
        echo '<li><img src="../images/icon-doller.png" alt="dollar"><strong>Price: </strong>$ ' . $row['propertyPrice'] . '</li>';
        echo '<li><img src="../images/icon-location.png" alt="location"><strong>Location: </strong>' . $row['propertyLocation'] . '</li>';
        echo '</ul>';
        echo '<p>' . $row['propertyDescription'] . '</p>';
        echo '</div>';
    }
} else {
    echo "Does'nt find any property!!!";
}
?>
