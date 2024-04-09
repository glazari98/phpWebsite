<?php session_start();
require_once ('connect.php');
//get the product id of the product the user pressed to 'read more'
if(isset($_GET['ReadMore'])){
    $_SESSION['productID'] = (int)$_GET['ReadMore'];
}
//submit a review into the database
if(isset($_GET['review'])){
    $title = $_GET['title'];
    $desc = $_GET['description'];
    $rating = $_GET['rating'];
    $stmt = $pdo->prepare("INSERT INTO tbl_reviews (user_id, product_id, review_title, review_desc, review_rating) VALUES(:user_id, :product_id, :review_title, :review_desc, :review_rating)");

    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->bindParam(':product_id', $_SESSION['productID']);
    $stmt->bindParam(':review_title', $title);
    $stmt->bindParam(':review_desc', $desc);
    $stmt->bindParam(':review_rating', $rating);
    $stmt->execute();
}
//if user presses logout, destroy all sessions and go to products page
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
    <title>Item</title>
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/design.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--For the hamburger menu to show-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div><a href='index.php'>Home</a></div>
        <div><a href='products.php'>Products</a></div>
        <div><a href='cart.php'>Cart</a></div>";
//if the user is logged in display the logout button, else display log in link to the cart
if(isset($_SESSION["name"])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
echo "</div>
    <!-- The hamburger_menu element appears when the screen window is below 768px-->
    <div id='hamburger_menu'>
        <i class='fa fa-bars'></i>
    </div>
</div>
<!-- The main element of cart page contains appropriate headings of shopping cart and the products added along with button
for remove a product or empty the basket and total price of items in the cart-->
<div class='main'>
    <div id='content'>
        <!-- the menu2 element is a second menu that appears after the click of the hamburger menu icon-->
        <div id='menu2'>
            <div><a href='index.php'>Home</a></div>
            <div><a href='products.php'>Products</a></div>
            <div><a href='cart.php'>Cart</a></div>";
//if the user is logged in display the logout button, else display log in link to the cart
if(isset($_SESSION["name"])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else{
    echo "<div><a href='cart.php'>Log in</a></div>";
}
        echo "</div>
        <!--In the itemPageItem div the image, description, price etc. of the item will appear-->
        <div id='itemPageItem'>";
//get the session containing the item id the user wants to view and display it
$connection = mysqli_connect("vesta.uclan.ac.uk", "glazari","KAJrY8Ct", "glazari");
$item = $_SESSION['productID'];
$myQuery = "SELECT * FROM tbl_products WHERE product_id LIKE '$item'";
$result = mysqli_query($connection, $myQuery);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<div id='item'>";
    echo "<img src='resources/$row[product_image]'>";
    echo "<h2>$row[product_title]</h2>";
    echo "<p>$row[product_desc].</p><br>";
    echo "<p>Only £ $row[product_price]</p>";
    echo "<button onclick='buy(\"$row[product_id],$row[product_image],$row[product_title],$row[product_price]\")'>Buy</button>";
    echo "</div>";
}
 echo "</div>";
//find the average rating of the product the user views
$myQuery = "SELECT ROUND(AVG(review_rating)) AS Average FROM tbl_reviews WHERE product_id LIKE '$item'";
$result = mysqli_query($connection, $myQuery);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    if ($row['Average'] != NULL) {
        echo "<div id='averageRating'><h2>Average rating:";
        for($i = 1; $i <= $row['Average']; $i++){
        //display stars according the number in the rating
        echo"<span class='material-icons'>star</span>";
        }
        echo "</h2></div>";
    }
}
$ratingValue = "";
//show item reviews
$myQuery = "SELECT review_title, review_desc, review_rating FROM tbl_reviews WHERE product_id LIKE '$item'";
$result = mysqli_query($connection, $myQuery);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    if($row['review_rating'] == '5'){
        $ratingValue = 'Excellent';
    }
    if($row['review_rating'] == '4'){
        $ratingValue = 'Good';
    }
    if($row['review_rating'] == '3'){
        $ratingValue = 'Average';
    }
    if($row['review_rating'] == '2'){
        $ratingValue = 'Poor';
    }
    if($row['review_rating'] == '1'){
        $ratingValue = 'Very Bad';
    }
    //display review information in a div element
    echo "<div class='review'>
            <h2>Title: $row[review_title]</h2>
            <p>Description: $row[review_desc]</p>
            <p id='rating'>Rating: $ratingValue</p>
            </div>";
}
//if the user is logged in display a form for the user to leave a review
if(isset($_SESSION['name'])){
    echo "
<form id='review' method='get'>
<h2>Write a review:</h2><label>Title</label><br><input type='text' name='title' required><br>
<label>Description</label><br><textarea name='description' wrap='hard' required></textarea><br>
<select name='rating'>
            <option value='Pick one' selected disabled> Pick one</option>
            <option value='5'>Excellent</option>
            <option value='4'>Good</option>
            <option value='3'>Average</option>           
            <option value='2'>Poor</option>                 
            <option value='1'>Very Bad</option>
        </select>
<input type='submit' name='review' value='Submit'></form>";
}

echo"
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
    //function for user to add item to the cart
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
<!--Functionalities of hamburger menu are implemented in the script below-->
<script src="js/hamburgerMenu.js"></script>
</body>
</html>