<?php
include_once("session.php");
include_once("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if any item was checked
    if (!isset($_POST['product_checkbox'])) {
        // If no item was checked, redirect back to the checkout page
        header("Location: checkout.php");
        exit();
    }

    // Validate and sanitize input data
    $shippingDetails = htmlspecialchars($_POST['address']);
    $modeOfPayment = htmlspecialchars($_POST['mode_of_payment']);

    // Get the current date
    $currentDate = date("Y-m-d"); // Change the date format if needed

    // Default status for the order
    $defaultStatus = "Pending";

    // Initialize total payment
    $totalPayment = 0;

    // Insert checkout details into the database
    $insertQuery = $conn->prepare("INSERT INTO checkout_tbl (customerID, productID, quantity, totalprice, shippingdetails, modeOfPayment, orderDate, orderStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Iterate through checked items only
    foreach ($_POST['product_checkbox'] as $orderId => $checked) {
        if ($checked == "on") { // Only process checked items
            $productId = $_POST['product_id'][$orderId];
            $quantity = $_POST['quantity'][$orderId];
            $totalPrice = $_POST['total_price'][$orderId];
            
            // Update total payment
            $totalPayment += $totalPrice;

            // Fetch customer ID from session
            $customerId = $_SESSION['cid'];

            // Insert checkout details for each checked product in the cart
            $insertQuery->execute([$customerId, $productId, $quantity, $totalPrice, $shippingDetails, $modeOfPayment, $currentDate, $defaultStatus]);
        }
    }

    // Redirect to a success page or any other page as needed
    header("Location: checkoutsuccess.php?total_payment=" . $totalPayment);
    exit();
}

// Fetch user's cart items from the database
$query = $conn->prepare("SELECT order_tbl.orderID, order_tbl.productID, products_tbl.productName, products_tbl.productPrice, products_tbl.productPicture, order_tbl.quantity, order_tbl.totalprice FROM order_tbl INNER JOIN products_tbl ON order_tbl.productID = products_tbl.productID WHERE order_tbl.customerID = ?");
$query->execute([$_SESSION['cid']]);
$cartItems = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Add your meta tags, title, and CSS links here -->
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Flores' Küche</title>
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
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th,
td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    text-align: left;
}

th {
    background-color: #f9f9f9;
}

.total-price {
    font-weight: bold;
    margin-bottom: 10px;
}

button {
    padding: 10px 20px;
    background-color: #638889;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #9dbc98;
}

a {
    text-decoration: none;
}

a button {
    margin-right: 10px;
}

a button:last-child {
    margin-right: 0;
}

        
    </style>
</head>
<body>
    <!-- Add your header HTML here -->
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
        <h1>Checkout</h1>
        
        <!-- Shipping details form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="shipping-details">
                <label for="address">Shipping Details:</label><br>
                <textarea id="shipping_details" name="address" rows="4" cols="50" required><?php echo isset($addre) ? htmlspecialchars($addre) : ''; ?></textarea>
            </div>

            <div class="mode-of-payment">
                <label for="mode_of_payment">Mode of Payment:</label><br>
                <select id="mode_of_payment" name="mode_of_payment" required>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                    <option value="Credit Card">Credit Card</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Select</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <img src="../admin/product_photos/<?php echo $item['productPicture']; ?>" alt="<?php echo $item['productName']; ?>"style="width: 100px; height: 100px;">
                            <br>
                            <?php echo $item['productName']; ?>
                        </td>
                        <td><?php echo "&#8369;" . $item['productPrice']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo "&#8369;" . $item['totalprice']; ?></td>
                        <td><input type="checkbox" name="product_checkbox[<?php echo $item['orderID']; ?>]" class="product-checkbox" value="on"></td>
                        <!-- Hidden fields to pass product details to the server -->
                        <input type="hidden" name="product_id[<?php echo $item['orderID']; ?>]" value="<?php echo $item['productID']; ?>">
                        <input type="hidden" name="quantity[<?php echo $item['orderID']; ?>]" value="<?php echo $item['quantity']; ?>">
                        <input type="hidden" name="total_price[<?php echo $item['orderID']; ?>]" value="<?php echo $item['totalprice']; ?>">
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>Grand Total: <span id="total-price">0.00</span></div>
            <button type="submit">Proceed to Checkout</button>
        </form>
        <a href="cart.php"><button>Return to Cart</button></a>
    </div>

    <script>
        // Function to calculate total price of checked items
        function calculateTotal() {
            var checkboxes = document.querySelectorAll('.product-checkbox:checked');
            var totalPrice = 0;

            checkboxes.forEach(function(checkbox) {
                var orderId = checkbox.name.split('[')[1].split(']')[0];
                var quantity = parseInt(document.querySelector('input[name="quantity[' + orderId + ']"]').value);
                var totalprice = parseFloat(document.querySelector('input[name="total_price[' + orderId + ']"]').value);
                totalPrice += totalprice;
            });

            // Display the total price
            document.getElementById('total-price').innerText = '₱' + totalPrice.toFixed(2);
        }

        // Call the function initially
        calculateTotal();

        // Add event listener to recalculate total price when checkboxes are changed
        var checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Add event listener for select all checkbox
        var selectAllCheckbox = document.getElementById('select-all');
        selectAllCheckbox.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });

            // Recalculate total price
            calculateTotal();
        });
    </script>

    <!-- Add your footer HTML here -->
</body>
</html>
