<?php
include_once("conn.php");

session_start();

if(isset($_SESSION['cid'])) {
    $uid = $_SESSION['cid'];
    
    $stmt = $conn->prepare("SELECT * FROM customer_tbl WHERE cusID = :id");
    $stmt->bindParam(":id", $uid);
    $stmt->execute();

    while($data = $stmt->fetch()){
        $pangalan = $data['cusFname'];
        $middlename = $data['cusMname'];
        $huling = $data['cusLname'];
        $email = $data['cusEmail'];
        $username = $data['cusUsername'];
        $addre = $data['cusAddress'];
        $pic = $data['cusPicture']; 
        $eid = $data['cusID'];
    }

    } else {
    header("Location: ../login.php");
    die();
}
?>