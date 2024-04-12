<?php
include_once("session.php");
include_once("conn.php");

// Fetch count of users
$userCountQuery = $conn->query("SELECT COUNT(*) AS totalUsers FROM customer_tbl");
$userCount = $userCountQuery->fetch(PDO::FETCH_ASSOC);

// Fetch count of products
$productCountQuery = $conn->query("SELECT COUNT(*) AS totalProducts FROM products_tbl");
$productCount = $productCountQuery->fetch(PDO::FETCH_ASSOC);

// Fetch count of orders
$orderCountQuery = $conn->query("SELECT COUNT(*) AS totalOrders FROM checkout_tbl");
$orderCount = $orderCountQuery->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        #nav {
            background-color: #f4f4f4;
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ccc;
        }
        #nav a {
            display: block;
            padding: 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #ccc;
        }
        #nav a:hover {
            background-color: #ddd;
        }
        #content {
            margin-left: 250px;
            padding: 20px;
        }
        h1 {
            color: #333;
        }

        .summary-box {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="header">
        <h1>Admin Dashboard</h1>
    </div>
    
    <div id="nav">
        <a href="viewrecords.php">Manage Users</a>
        <a href="addproduct.php">Add Product</a>
        <a href="viewproducts.php">View Products</a>
        <a href="vieworders.php">View Orders</a>
        <a href="logout.php">Logout</a>
    </div>
    
    <div id="content">
        <h1>Welcome to the Admin Dashboard</h1>
        
        <!-- Summary section for users -->
        <div class="summary-box">
            <h2>Users</h2>
            <p>Total Users: <?php echo $userCount['totalUsers']; ?></p>
            <!-- You can add more details here if needed -->
        </div>
        
        <!-- Summary section for products -->
        <div class="summary-box">
            <h2>Products</h2>
            <p>Total Products: <?php echo $productCount['totalProducts']; ?></p>
            <!-- You can add more details here if needed -->
        </div>
        
        <!-- Summary section for orders -->
        <div class="summary-box">
            <h2>Orders</h2>
            <p>Total Orders: <?php echo $orderCount['totalOrders']; ?></p>
            <!-- You can add more details here if needed -->
        </div>
    </div>
</body>
</html>
