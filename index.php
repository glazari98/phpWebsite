<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--For the hamburger menu to show-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/design.css">
</head>
<body>
<?php
echo "
<!--The header element contains the logo, student shop heading and the navigation menu -->
<div class='header'>
    <div id='logo'>
        <img src='resources/UCLAN-white-orizontal.png' alt='uclanLogo'>
    </div>
    <div id='studentShopHeading'>
        <h1>Student Shop</h1>
    </div>
    <div id='menu1'>
        <div><a href='signUp.php'>Sign Up</a></div>        
        <div><a href='products.php'>Products</a></div>
        <div><a href='cart.php'>Cart</a></div>
    </div>
    <!-- The hamburger_menu element appears when the screen window is below 768px-->
    <div id='hamburger_menu'>
        <i class='fa fa-bars'></i>
    </div>
</div>
<!-- The main element contains appropriate headings and paragraphs for the welcoming page along with an html5 video and a
youtube video-->
<div class='main'>
    <div id='content'>
        <!-- the menu2 element is a second menu that appears after the click of the hamburger menu icon-->
        <div id='menu2'>
            <div><a href='signUp.php'>Sign Up</a></div>            
            <div><a href='products.php'>Products</a></div>
            <div><a href='cart.php'>Cart</a></div>
        </div>
        <h1>Offers <i class='material-icons'>discount</i></h1>
        
        <div id='offers'>";
    $connection = mysqli_connect("vesta.uclan.ac.uk", "glazari","KAJrY8Ct", "glazari");
    //show offers from database
    $myQuery = "SELECT * FROM tbl_offers";
    $result = mysqli_query($connection, $myQuery);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<div class='offer'>
           <h2>$row[offer_title]</h2>
           <p>$row[offer_dec]</p>
            </div>";
    }
echo"</div>
        <h1>Where opportunity creates success</h1>
        <p>Every student at The University Of Central Lancashire is automatically a member of the Student's Union. <br>
            We're here to make life better for students-inspiring you to succeed and achieve your goals.<br><br>
            Everything you need to know about UCLan students' Union. Your membership starts here.</p>
        <h1>Together</h1>
        <!--Html5 video-->
        <video controls>
            <source src='resources/UCLan%20Together.mp4'>
        </video>
        <h1>Join Our Community</h1>
        <!--Youtube video-->
        <iframe width='853' height='480' src='https://www.youtube.com/embed/i2CRunZv9CU' title='UCLan Together – Join our global community'  allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>
    </div>
</div>
<!-- The footer element contains the links, contact and location information about UCLan-->
<div class='footer'>
    <div id='links'>
        <h2>Links</h2>
        <a href=''>Students' Union</a>
    </div>
    <div id='contact'>
        <h2>Contact</h2>
        <p>Email: suinformation@uclan.ac.uk</p>
        Phone: 0900 93 0395
    </div>
    <div id='location'>
        <h2>Location</h2>
        <p>University of Central Lancashire Students Union<br>
            Fylde Road, Preston, PR1 7BY<br>
            Registered in England<br>
            Company Number: 7623917<br>
            Registered Charity Number: 1142615
        </p>
    </div>
</div>";
?>
<!--Functionalities of hamburger menu are implemented in the script below-->
<script src="js/hamburgerMenu.js"></script>
</body>
</html>
