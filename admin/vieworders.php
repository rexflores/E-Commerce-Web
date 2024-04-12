<?php
include_once("session.php");
include_once("conn.php");

// Handle update order status request
if(isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    updateOrderStatus($orderId, $newStatus, $conn);
}

// Function to update order status
function updateOrderStatus($orderId, $newStatus, $conn) {
    $query = $conn->prepare("UPDATE checkout_tbl SET orderStatus = ? WHERE checkoutID = ?");
    $query->execute([$newStatus, $orderId]);
}

// Fetch all orders with user details from the database
$query = $conn->prepare("
    SELECT checkout_tbl.checkoutID, checkout_tbl.orderdate, checkout_tbl.totalprice, checkout_tbl.orderStatus, checkout_tbl.customerID, customer_tbl.cusUsername, customer_tbl.cusEmail, customer_tbl.cusAddress, products_tbl.productName, products_tbl.productPicture
    FROM checkout_tbl
    INNER JOIN customer_tbl ON checkout_tbl.customerID = customer_tbl.cusID
    INNER JOIN products_tbl ON checkout_tbl.productID = products_tbl.productID
");
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Order Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 120px;
        }

        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .header {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
        }

        .header button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <button onclick="window.location.href='index.php'">Dashboard</button>
        <button onclick="window.location.href='viewrecords.php'">Manage Users</button>
        <button onclick="window.location.href='addproduct.php'">Add Product</button>
        <button onclick="window.location.href='viewproducts.php'">View Products</button>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
    <div class="container">
        <h1>All Orders</h1>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Product Picture</th>
                <th>User</th>
                <th>Email</th>
                <th>Address</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['checkoutID']; ?></td>
                    <td><?php echo $order['productName']; ?></td>
                    <td><img src="../admin/product_photos/<?php echo $order['productPicture']; ?>" alt="<?php echo $order['productName']; ?>"></td>
                    <td><?php echo $order['cusUsername']; ?></td>
                    <td><?php echo $order['cusEmail']; ?></td>
                    <td><?php echo $order['cusAddress']; ?></td>
                    <td><?php echo $order['orderdate']; ?></td>
                    <td><?php echo "&#8369;" . $order['totalprice']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['checkoutID']; ?>">
                            <select name="new_status">
                                <option value="Pending" <?php echo ($order['orderStatus'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo ($order['orderStatus'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo ($order['orderStatus'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo ($order['orderStatus'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo ($order['orderStatus'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>

