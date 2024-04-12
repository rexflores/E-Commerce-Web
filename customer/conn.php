<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "recordsdb";

try{
$conn = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
	echo "Connetion Failed :", $e->getMessage();
}
?>