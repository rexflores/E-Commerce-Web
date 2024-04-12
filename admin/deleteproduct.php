<?php
include_once("conn.php");

$pid = $_GET['pid'];

$query = $conn->prepare("DELETE FROM products_tbl WHERE productID = :id");
$query->bindParam(":id", $pid);
$query->execute();

echo "<script>alert('Successfully Deleted')</script>";
echo "<script>window.open('viewproducts.php', '_self')</script>";
?>
