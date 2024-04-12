<?php
include_once("session.php");
// Include database connection
include_once("conn.php");

// Function to update quantity or remove product from cart
if (isset($_POST['update_cart'])) {
    if ($_POST['action'] === 'update') {
        $orderID = $_POST['order_id'];
        $quantity = $_POST['quantity'];

        // Fetch product price from the database
        $query = $conn->prepare("SELECT products_tbl.productPrice FROM products_tbl INNER JOIN order_tbl ON products_tbl.productID = order_tbl.productID WHERE order_tbl.orderID = ?");
        $query->execute([$orderID]);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $productPrice = $product['productPrice'];

        // Calculate new total price
        $totalPrice = $productPrice * $quantity;

        // Update quantity and total price in the database
        $updateQuery = $conn->prepare("UPDATE order_tbl SET quantity = ?, totalprice = ? WHERE orderID = ?");
        $updateQuery->execute([$quantity, $totalPrice, $orderID]);
    } elseif ($_POST['action'] === 'remove') {
        $orderID = $_POST['order_id'];

        // Remove product from the database
        $deleteQuery = $conn->prepare("DELETE FROM order_tbl WHERE orderID = ?");
        $deleteQuery->execute([$orderID]);
    }

    // Redirect back to cart page to reflect changes
    header("Location: cart.php");
    exit();
}

// Fetch user's cart items from the database including product picture
$query = $conn->prepare("SELECT order_tbl.orderID, products_tbl.productName, products_tbl.productPrice, products_tbl.productPicture, order_tbl.quantity, order_tbl.totalprice FROM order_tbl INNER JOIN products_tbl ON order_tbl.productID = products_tbl.productID WHERE order_tbl.customerID = ?");
$query->execute([$_SESSION['cid']]);
$cartItems = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script>
        function toggleAll(source) {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = source.checked;
            });
            calculateTotal();
        }

        function calculateTotal() {
    var checkboxes = document.querySelectorAll('.product-checkbox:checked');
    var totalPrice = 0;

    checkboxes.forEach(function(checkbox) {
        var orderID = checkbox.value;
        var quantity = parseInt(checkbox.dataset.quantity);
        var price = parseFloat(checkbox.dataset.price);
        totalPrice += quantity * price;
    });

    document.getElementById('total-price').innerText = totalPrice.toFixed(2);
}


    </script>

    <style>
        .logo {
            width: 100px; /* Adjust the width of your logo */
            height: 100px; /* Adjust the height of your logo */
            background-image: url('../logo/floreslogo.png'); /* Specify the path to your logo */
            background-size: cover;
            background-position: center;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F9EFDB; /* Lightest color */
            color: #638889; /* Darkest color for text */
        }

        .header {
            align-items: center;
            position: sticky;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-image: url('../logo/banner.png'); /* Specify the path to your background image */
            background-size: cover; /* Ensure the background image covers the entire header */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent the background image from repeating */
            color: #638889; /* Text color */
            z-index: 9999; /* Ensure header is above other elements */
        }

        .header-buttons {
            display: flex;
        }

        .header-buttons a {
            text-decoration: none;
            color: #638889; /* Darkest color */
            margin-left: 10px;
        }

        .header-buttons a:last-child {
            margin-left: 0;
        }

        .header-buttons button {
            padding: 10px 20px;
            background-color: #EBD9B4; /* Third color */
            border: none;
            border-radius: 5px;
            color: #638889; /* Darkest color */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 10px;
        }

        .header-buttons button:hover {
            background-color: #638889; /* Darkest color */
            color: #F9EFDB; /* Lightest color */
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #F9EFDB; /* Lightest color */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .products {
            margin-top: 100px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }

        .product {
            background-color: #EBD9B4; /* Third color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 100%;
            border-radius: 5px;
        }

        .product h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #638889; /* Darkest color */
        }

        .product p {
            margin-top: 5px;
            font-size: 14px;
            color: #638889; /* Darkest color */
        }

        .product button {
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #638889; /* Darkest color */
            border: none;
            border-radius: 5px;
            color: #F9EFDB; /* Lightest color */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product button:hover {
            background-color: #9DBC98; /* Second color */
        }

        .quantity-input {
            margin-top: 10px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 60px;
        }

        .search-bar {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            border: 1px solid #638889; /* Darkest color */
            border-radius: 5px;
            box-sizing: border-box;
        }

        
        .cart-btn {
            margin-right: 10px; /* Add space between the cart button and the user picture */
        }

        .user-avatar {
            width: 30px; /* Adjust the width of the user avatar */
            height: 30px; /* Adjust the height of the user avatar */
            border-radius: 50%; /* Make it circular */
            margin-right: 10px; /* Add some space between the avatar and the username */
            vertical-align: middle; /* Align the avatar vertically */
        }

        .user-btn {
            vertical-align: middle; /* Align the username vertically */
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
            vertical-align: middle; /* Align the entire dropdown vertically */
        }


        .dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 1px); /* Adjust the distance from the top */
            right: 0; /* Align with the right side of the container */
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 8px 14px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #f9efdb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ebd9b4;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .cart-btn {
            background-color: #638889;
            color: #f9efdb;
        }

        .cart-btn:hover {
            background-color: #9dbc98;
        }

        .quantity-input {
            width: 60px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 8px 15px;
            background-color: #638889;
            border: none;
            border-radius: 5px;
            color: #f9efdb;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #9dbc98;
        }

        .total-price {
            font-weight: bold;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .actions a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #f9efdb;
        }

        .continue-shopping {
            background-color: #9dbc98;
        }

        .proceed-to-checkout {
            background-color: #638889;
        }

        .actions a:hover {
            opacity: 0.8;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="index.php"></a>
        </div>
        <div class="header-buttons">
            <a href="index.php"><button class="home">Home</button></a>
            <a href="cart.php"><button class="cart-btn">My Cart</button></a>
            <?php if(isset($_SESSION['cid'])): ?>
                <div class="user-dropdown">
                    <img class="user-avatar" src="../admin/photos/<?php echo $pic;?>" alt="profile picture">
                    <button class="user-btn">
                        <?php echo $username; ?> <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="edit.php">Account Settings</a>
                        <a href="viewpurchase.php">View Purchase</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../login.php"><button class="login-btn">Login</button></a>
                <a href="../signup.php"><button class="signup-btn">Sign Up</button></a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h1>My Cart</h1>
        <table>
            <tr>
                <th>Select All <input type="checkbox" onchange="toggleAll(this)"></th> <!-- Add a checkbox to toggle all products -->
                <th>Product</th>
                <th>Image</th> <!-- Add a column for the product image -->
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td> <!-- Add a checkbox for each product -->
                            <input type="checkbox" class="product-checkbox" name="product_checkbox[<?php echo $item['orderID']; ?>]" value="<?php echo $item['orderID']; ?>" data-quantity="<?php echo $item['quantity']; ?>" data-price="<?php echo $item['productPrice']; ?>" onchange="calculateTotal()">
                        </td>
                        <td><?php echo $item['productName']; ?></td>
                        <td><img src="../admin/product_photos/<?php echo $item['productPicture']; ?>" alt="<?php echo $item['productName']; ?>" style="width: 100px;"></td> <!-- Display the product image -->
                        <td><?php echo "&#8369;" . $item['productPrice']; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="order_id" value="<?php echo $item['orderID']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <button type="submit" name="update_cart">Update</button>
                            </form>
                        </td>
                        <td><?php echo "&#8369;" . $item['totalprice']; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="order_id" value="<?php echo $item['orderID']; ?>">
                                <button type="submit" name="update_cart">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

        </table>

        <div>Grand Total: &#8369; <span id="total-price">0.00</span></div>

        <a href="index.php"><button>Continue Shopping</button></a>
        <a href="checkout.php"><button>Proceed to Checkout</button></a>
    </div>
</body>
</html>

