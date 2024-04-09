<?php
session_start();
//when the user logs out, destroy all sessions and refrsh the page
if(isset($_GET['logout'])){
    unset($_GET['logout']);
    session_unset();
    session_destroy();
    echo "<script>
    location.href  = 'cart.php';

</script>";
}

// Check if the form was submitted
if(isset($_GET['password']) && isset($_GET['email'])) {
    $confirm = $_GET['password'];
    $_SESSION['email'] = $_GET['email'];

    // Connect to the database and validate user credentials
    $connection = mysqli_connect("vesta.uclan.ac.uk", "glazari","KAJrY8Ct", "glazari");
    $myQuery = "SELECT user_id, user_full_name,user_pass FROM tbl_users WHERE user_email= '".$_SESSION['email']."'";
    $result = mysqli_query($connection, $myQuery);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        //verify the password matches with the hashed one in database
        if (password_verify($confirm, $row["user_pass"])) {
            // Set the user's full name in the session variable
            $_SESSION['name'] = "Hello " .$row["user_full_name"]. ". ";
            $_SESSION['id'] = (int)$row["user_id"];
        }
    }
}

require_once ('connect.php');
//to prevent it from submiting, if the basket is empty
if(isset($_GET['productIDs']) && $_GET['productIDs'] !== "") {
    $productIDs = $_GET['productIDs'];
    //sent the order to the database
    $stmt = $pdo->prepare("INSERT INTO tbl_orders (user_id, product_ids) VALUES(:user_id, :product_ids)");

    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->bindParam(':product_ids', $productIDs);
    $stmt->execute();


}
//if the user presses check out
//if the user presses check out and there are products in the cart, place the order
if(!empty($_GET['productIDs'])){
    unset($_GET['productIDs']);
    echo"<script>alert('Your order has been placed')
               localStorage.clear();
                location.href = 'cart.php';
               </script>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <!--For responsiveness-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/design.css">
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
        <div><a href='products.php'>Products</a></div>";
//if the user is logged in show the log out button, else show sign up link
if(isset($_SESSION["name"])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else {
    echo "<div><a href='signUp.php'>Sign Up</a></div>";
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
            <div><a href='products.php'>Products</a></div>";
if(isset($_SESSION["name"])){
    echo "<form method='get'><input id='logout' type='submit' name='logout' value='Log out'></form>";
}
else {
    echo "<div><a href='signUp.php'>Sign Up</a></div>";
}
        echo "</div>
        <div id='titles'>
            <h1>Shopping Cart</h1>";
//greeting showing user's name when they login
if(isset($_SESSION["name"])){
    echo "<p>$_SESSION[name]The items you have added in your shopping cart are:</p>";
}
else{
    echo "<p>The items you have added in your shopping cart are:</p>";
}

echo "            
            
            <!-- the headings element contains the item heading for numbering the products added below and the product heading
            for showing the name of product below-->
            <div id='headings'><h2>Item</h2><h2>Product</h2></div>
        </div>
        <!--In the cart div the image, name, color and price of product are shown along with the remove item button-->
        <div id='cart'>
        </div>
        <!-- in the total price div, the total price of all items added in the cart will show-->
        <div id='totalPrice'></div>
        <!--Button to empty the basket-->
        <button onclick='emptyBasket()' id='basket'>Empty the basket</button>";
//if user is logged in show the check out button
if(isset($_SESSION['name'])){
    echo "<form id='checkOut' method='get' >
            <input type='hidden' name='productIDs' id='idsInput' required>
            <input type='submit' id='checkout' value='Check Out'>
            </form></div>
    ";
    //table for pending orders of user
    echo "<div id='pendingOrders'><h1>Your pending orders:</h1><table class='ordersTable'>
                <thead>
                 <tr>
                    <th class='order'>Order Id</th>
                    <th class='order'>Order date/time</th>
                    <th class='order'>Product Ids</th>                    
                </tr>
            </thead>
            <tbody>";
    //show the user's pending orders when they login
    $connection = mysqli_connect("vesta.uclan.ac.uk", "glazari","KAJrY8Ct", "glazari");
    if(isset($_SESSION['email'])) {
        $myQuery = "SELECT A.order_id, A.order_date, A.product_ids, A.user_id FROM tbl_orders A, tbl_users B WHERE A.user_id = B.user_id AND B.user_email = '".$_SESSION['email']."'";
        $result = mysqli_query($connection, $myQuery);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $product_ids_array = json_decode($row['product_ids']);
            $product_string = '';
            if(count($product_ids_array) > 1) {
                foreach ($product_ids_array as $product) {
                    $product_string .= $product . ', ';
                }
            }else{
                $product_string = $product_ids_array[0];
            }
            //display details of order
            echo "<tr>
                <td>$row[order_id]</td>
                <td>$row[order_date]</td>
                <td>$product_string</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    }
}else{
    echo"</div> 
    <div id='login'>   
    <h3>Login in order to checkout. If you have not signed up you can sign up here: <a href='signUp.php'>Sign Up</a></h3>
    <form id='loginForm' method='get'>
    <label>Username</label><br>
    <input type='email' name='email' required><br>
    <label>Password</label><br>
    <input type='password' id='password' name='password' required><br>
    <input type='checkbox' id='checkbox' onclick='showHidePassword()'>Show Password<br>
    <input id='submit' type='submit'>    
</form></div> ";
}
echo "
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
    //create an array of the product ids of products in the cart and make it the value of hidden input in check out form
    //in this way when the user checks out we use the array to send the product ids to the database
    var productIDs = [];
    if(localStorage.length > 0) {
        for (let i = 0; i <= localStorage.length; i++) {
            if (localStorage.getItem(`item${i}`) !== null) {
                //split array of each local storage item and retrieve the first index which is the id
                let item = localStorage.getItem(`item${i}`).split(',');
                productIDs.push(`${item[0]}`);
                //the value of the hidden input is the array of product ids
                document.getElementById('idsInput').value = JSON.stringify(productIDs);
            }
        }
    }


</script>
<!--In the cart functionalities script is the implimentation of showing a product added in the cart, remove a product
from the cart, empty the cart and show total price-->
<script src="js/cartFunctionality.js"></script>
<!--Functionalities of hamburger menu are implemented in the script below-->
<script src="js/hamburgerMenu.js"></script>
<script src="js/signupFunctionality.js"></script>
</body>
</html>