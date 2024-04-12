<?php
include_once("session.php");
include_once("conn.php");

// Function to cancel order
function cancelOrder($orderId, $conn) {
    $query = $conn->prepare("UPDATE checkout_tbl SET orderStatus = 'Cancelled' WHERE checkoutID = ?");
    $query->execute([$orderId]);
}

// Handle cancel order request
if(isset($_POST['cancel_order'])) {
    $orderId = $_POST['order_id'];
    cancelOrder($orderId, $conn);
}

// Fetch user's purchase history with product details from the database
$query = $conn->prepare("
    SELECT checkout_tbl.checkoutID, checkout_tbl.orderdate, checkout_tbl.totalprice, checkout_tbl.orderStatus, products_tbl.productName, products_tbl.productPicture
    FROM checkout_tbl
    INNER JOIN products_tbl ON checkout_tbl.productID = products_tbl.productID
    WHERE checkout_tbl.customerID = ?
");
$query->execute([$_SESSION['cid']]);
$purchaseHistory = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Purchase History</title>

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

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #638889;
        }

        th {
            background-color: #EBD9B4;
            color: #638889;
        }

        /* Button Styles */
        button {
            padding: 8px 15px;
            background-color: #638889;
            border: none;
            border-radius: 5px;
            color: #F9EFDB;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #9DBC98;
        }

        /* Image Styles */
        img {
            max-width: 100px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header-buttons {
                flex-direction: column;
            }
            .header-buttons a, .header-buttons button {
                margin: 5px 0;
            }
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
                        <a href="#">View Purchase</a>
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
        <h1>Purchase History</h1>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Product Picture</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($purchaseHistory as $purchase): ?>
                <tr>
                    <td><?php echo $purchase['productName']; ?></td>
                    <td><img src="../admin/product_photos/<?php echo $purchase['productPicture']; ?>" alt="<?php echo $purchase['productName']; ?>" style="max-width: 100px;"></td>
                    <td><?php echo $purchase['orderdate']; ?></td>
                    <td><?php echo "&#8369;" . $purchase['totalprice']; ?></td>
                    <td><?php echo $purchase['orderStatus']; ?></td>
                    <td>
                        <?php if($purchase['orderStatus'] == 'Pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $purchase['checkoutID']; ?>">
                                <button type="submit" name="cancel_order">Cancel</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Add your footer HTML here -->
    <!-- Replace this with your footer code -->
</body>
</html>
