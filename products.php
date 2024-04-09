<?php session_start();
//if user presses logout, destroy all sessions
if(isset($_GET['logout'])) {
    unset($_GET['logout']);
    session_unset();
    session_destroy();
    echo "<script>
        location.href  = 'products.php';

</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/design.css">
    <!--For the hamburger menu icon to show-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
<?php
//The header element contains the logo, student shop heading and the navigation menu -->
echo "<div class='header'>    
   <div id='logo'>
        <img src='resources/UCLAN-white-orizontal.png' alt='uclanLogo'>
    </div>
    <div id='studentShopHeading'>
        <h1>Student Shop</h1>
    </div>
    <div id='menu1'>        
        <div><a href='index.php'>Home</a></div>        
        <div><a href='cart.php'>Cart</a></div>";
//if the user is logged in display the logout button, else display log in link to the cart
if(isset($_SESSION['name'])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
 echo"   </div>
    <!-- The hamburger_menu element appears when the screen window is below 768px-->
    <div id='hamburger_menu'>
        <i class='fa fa-bars'></i>
    </div>
</div>
<!--Button having fucntionality to take you to the top of the page-->
<button id='topButton' onclick='goTop()'>Top</button>
<!-- The main element contains divs for each product and also a filter element that uses anchor tags to navigate to certain
products-->
<div class='main'>
    <div id='content'>
        <!-- the menu2 element is a second menu that appears after the click of the hamburger menu icon-->
        <div id='menu2'>            
            <div><a href='index.php'>Home</a></div>            
            <div><a href='cart.php'>Cart</a></div>";
//if the user is logged in display the logout button, else display log in link to the cart
if(isset($_SESSION['name'])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
        echo "</div>
        <!--Navigate to the first, hoodie or jumper or t-shirt using the product's id-->
        <div id='navigate'><span class='material-symbols-outlined'>filter_alt</span>
        <form name='form2' method='get'>
            <input class='filtering' type='submit' name='Jumpers' value='Jumpers'>
            <input class='filtering' type='submit' name='Hoodies' value='Hoodies'>
            <input class='filtering' type='submit' name='T-Shirts' value='Tshirts'>
            <input class='filtering' type='submit' name='All' value='All'>
        </form>
             
            
        </div>       
        <form id='search' name='form3' method='get'>
        <span class='material-symbols-outlined'>search</span>
        <input type='text' name='searchCriterion'><br>
        <!--Prices<br>£39.99 <input type='radio' name='price' value='39.99'>
        £29.99 <input type='radio' name='price' value='29.99'>
        £19.99 <input type='radio' name='price' value='19.99'>-->
        <input type='submit' value = 'Search'>        
</form>


</form>
        <!--Div element where the img, description price etc. of the product will be added-->
    <div id='item'>";

//searching
$search1 = "";
$search2 = "";
//filtering for all hoodie or all jumpers or all t-shirts
if(isset($_GET['Jumpers'])){
    $search1 = 'Jumper';
    echo '<br>';
}
if(isset($_GET['Hoodies'])){
    $search1 = 'Hoodie';
    echo '<br>';
}if(isset($_GET['T-Shirts'])){
    $search1 = 'Tshirt';
    echo '<br>';
//all products
}if(isset($_GET['All'])){
    $search1 = '';
    echo '<br>';
}
//search bar advances search for multiple entered words
if (isset($_GET["searchCriterion"])) {
    $search2 = $_GET["searchCriterion"];
    //separate the search input by space values into strings indexes in an array
    $searchSentence = explode(" ", $search2);
    echo '<br>';
$searchArray = array();
//make a new array with the string indexes entered adding the query words that will be used to search in the database
foreach ($searchSentence as $word) {
    $searchArray[] = "product_title LIKE '%$word%'";
    }
}
        $connection = mysqli_connect("vesta.uclan.ac.uk", "glazari","KAJrY8Ct", "glazari");

        //if the user has searched for a word or multiple words
        if(!empty($searchArray)) {
            //join the indexes of the query array($searchArray) above into one string with AND in between
            //In this way the user can find products where their title has both words
            $myQuery = "SELECT * FROM tbl_products WHERE " . implode(" AND ", $searchArray);
        }else{
            //if the user doesn't search then all products will be shown or categories fo products selected
            $myQuery = "SELECT * FROM tbl_products WHERE product_title LIKE '%$search1%'";
        }
        //display products
        $result = mysqli_query($connection, $myQuery);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<section class='product' id='$row[product_id]'>";
            echo "<div>";
            echo "<img src='resources/$row[product_image]'>";
            echo "<h2>$row[product_title]</h2>";
            echo "<div  id='desc' style='display: inline-block;'>";
            echo "<p style='display: inline;'>$row[product_desc]</p>";
            echo "<form style='display: inline;' name='form1' method='get' action='item.php'>
        <input type='hidden' name='ReadMore' placeholder='ReadMore' value='$row[product_id]'>
        <input type='submit' id='readMore' value='See More'>
        </form></div>";
            echo "<p id='productPrice'>Only £$row[product_price]</p>";
            echo "<button onclick='buy(\"$row[product_id],$row[product_image],$row[product_title],$row[product_price]\")'>Buy</button>";
            echo "</div>";
            echo "</section>";
        }

        echo "</div>
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
        University of Central Lancashire Students Union<br>
        Fylde Road, Preston, PR1 7BY<br>
        Registered in England<br>
        Company Number: 7623917<br>
        Registered Charity Number: 1142615
    </div>
</div>";
        ?>
<script>
//fucntion to add elements in the cart
function buy(elementP) {
    let localStorageCapacity = 0;
    //check how many items the local storage has and make a variable to store the number of items in the local storage
    for (let i = 0; i <= localStorage.length; i++) {
        if (localStorage.getItem(`item${i}`) !== null) {
            localStorageCapacity++;
        }
    }
    //split the string passed to the function, into an array of strings
    let array = elementP.split(',');
    alert(array[2] + " has been added to your cart!");
    //use localStorageCapacity variable as key and the array as value and add them to local storage
    localStorage.setItem("item" + localStorageCapacity, array);

    localStorageCapacity++;

}
</script>
<!-- In the productsFunctionalities script is the implementation of showing each product and adding it to local storage-->
<script src='js/productFunctionalities.js'></script>
<!--Functionalities of hamburger menu are implemented in the script below-->
<script src="js/hamburgerMenu.js"></script>
</body>

</html>
