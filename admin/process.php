<?php
include_once("conn.php");

    if(isset($_POST['login'])){
        $username = $_POST['uname'];
        $password = $_POST['pword'];

        session_start();

        $query = $conn->prepare("SELECT * FROM admin_tbl WHERE adUsername = :uname  AND adPassword = :pword");
        $query->bindParam(":uname", $username);
        $query->bindParam(":pword", $password);
        $query->execute();

        $count = $query->rowCount();

        if($count > 0){
            while($row = $query->fetch()){
                $id = $row['adminID'];

                $_SESSION['id'] = $id;
                header("Location: index.php");
            }
        } else {
            echo "<script>alert('Invalid Username or Password')</script>";
            echo "<script>window.location='login.php'</script>";
        }
    }
?>