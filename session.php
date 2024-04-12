<?php
session_start();

if(isset($_SESSION['cid'])) {
    } else {
    header("Location: login.php");
    die();
}
?>