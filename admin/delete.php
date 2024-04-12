<?php
include_once("conn.php");

$uid = $_GET['uid'];

$query = $conn->prepare("DELETE FROM customer_tbl WHERE cusID= :id");
$query->bindParam(":id",$uid);
$query->execute();

echo "<script>alert('Successfully Deleted')</script>";
echo "<script>window.open('viewrecords.php', '_self')</script>";

?>