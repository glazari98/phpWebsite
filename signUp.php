
<?php
session_start();
//if the user logs out, destroy all sessions and refresh the page
if (isset($_GET['logout'])) {
    unset($_GET['logout']);
    session_unset();
    session_destroy();
    echo "<script>
        location.href  = 'signUp.php';

</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--For the hamburger menu to show-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/design.css">
</head>
<body>
<?php
require_once ('connect.php');
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
        <div><a href='index.php'>Home</a></div>
        <div><a href='products.php'>Products</a></div>
        <div><a href='cart.php'>Cart</a></div>";
//if the user is logged in show the log out button, else show lon in link to the cart
if(isset($_SESSION['name'])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
    echo"</div>
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
            <div><a href='cart.php'>Cart</a></div>";
if(isset($_SESSION['name'])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
        echo"</div>
        <div id='signup' onsubmit='return samePassword()'>
        <h1>Sign Up</h1>
        <p>In order to purchase products from the UCLan student Union item shop you need to create an account with all the fields below required.</p>
            <form id='signUpForm' method='get'>
            <label>Full Name</label><br>
            <input type='text' name='name' id='name' required><br>
            <label>Email Address</label><br>
            <input type='email' name='email' id='email' required><br>
            <label>Password</label><br>
            <p>Must contain at one number and one uppercase and lowercase letter, and at least 8 or more characters</p>
            <!-- function to check if the password is the same -->
            <!--https://stackoverflow.com/questions/74583046/how-to-validate-password-from-input-field-in-html-->
            <input type='password' name='password' id='password' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' required onkeyup='checkPassword()'><br>   
            <!--Requirements for password, display only when user types in password input field -->  
            <div id='passwordRequirements' style='display: none'>                <ul>
                    <li id='lowercase'>Contains a lowercase letter<i id='lowerState' class='material-icons' style='color: red'>close</i></li>
                    <li id='uppercase'>Contains an uppercase(capital) letter<i id='upperState' class='material-icons' style='color: red'>close</i></li>
                    <li id='number'>Contains a number<i id='numberState' class='material-icons' style='color: red'>close</i></li>
                    <li id='min8'>Contains at least 8 characters<i id='charState' class='material-icons' style='color: red'>close</i></li>
                </ul>
            </div>
            <label>Confirm Password</label><br>
            <input type='password' id='confirmPassword' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' required><br>
             <input type='checkbox' id='checkbox' onclick='showHidePassword()'>Show Password<br>
            <label>Address</label><br>
            <!--https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_textarea_wrap-->
            <textarea id='address' name='address' rows='5' wrap='hard' required></textarea><br>
            <input id='submit' type='submit'>            
            </form>
        </div>
    </div>
</div>";
$name = "";
$email = "";
$password = "";
$address = "";
//check if all input fields have been field and send information of registration to database
if(isset($_GET['name']) && isset($_GET['password']) && isset($_GET['email']) && isset($_GET['address'])){
    $name = $_GET['name'];
    $password = password_hash($_GET['password'], PASSWORD_DEFAULT);
    $email = $_GET['email'];
    $address = $_GET['address'];
    //add information to tbl_users
    $stmt = $pdo->prepare("INSERT INTO tbl_users (user_full_name, user_email, user_address,user_pass) VALUES(:user_full_name, :user_email, :user_address, :user_pass)");
    $stmt->bindParam(':user_full_name', $name);
    $stmt->bindParam(':user_email', $email);
    $stmt->bindParam(':user_address', $address);
    $stmt->bindParam(':user_pass', $password);
    $stmt->execute();
    echo"<script>alert('You have registered successfully');</script>";
}
echo "       
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
<script src="js/signupFunctionality.js"></script>
<!--Functionalities of hamburger menu are implemented in the script below-->
<script src="js/hamburgerMenu.js"></script>
</body>
</html>
