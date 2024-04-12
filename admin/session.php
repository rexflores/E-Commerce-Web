<?php
session_start();

if(isset($_SESSION['id'])) {
    } else {
    header("Location: login.php");
    die();
}
?>