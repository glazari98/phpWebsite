<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--For the hamburger menu to show-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- link for icon api -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/design.css">
</head>
<body>
<?php
echo"
<!--The header element contains the logo, student shop heading and the navigation menu -->
<div class='header'>
    <div id='logo'>
        <img src='resources/UCLAN-white-orizontal.png' alt='uclanLogo'>
    </div>
    <div id='studentShopHeading'>
        <h1>Student Shop</h1>
    </div>
    <div id='menu1'>
        <div><a href='index.php'>Home</a></div>        
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
            <div><a href='index.php'>Home</a></div>            
            <div><a href='products.php'>Products</a></div>             
            <div><a href='cart.php'>Cart</a></div>
        </div>
        <!-- Error message with icons -->
        <div id='page404'><h2><span class='material-symbols-outlined'>warning</span>404<span class='material-symbols-outlined'>warning</span></h2>
        <h3>Page not found</h3>
        <p>The page you are looking for does not exist or another error occured!!!</p>
        </div>
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
