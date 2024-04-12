<?php
include_once("conn.php");

    if(isset($_POST['login'])){
        $username = $_POST['uname'];
        $password = sha1($_POST['pword']);

        session_start();

        $query = $conn->prepare("SELECT * FROM customer_tbl WHERE cusUsername = :uname  AND cusPassword = :pword");
        $query->bindParam(":uname", $username);
        $query->bindParam(":pword", $password);
        $query->execute();

        $count = $query->rowCount();

        if($count > 0){
            while($row = $query->fetch()){
                $id = $row['cusID'];

                $_SESSION['cid'] = $id;
                header("Location: index.php");
            }
        } else {
            echo "<script>alert('Invalid Username or Password')</script>";
            echo "<script>window.location='../login.php'</script>";
        }
    }
?>