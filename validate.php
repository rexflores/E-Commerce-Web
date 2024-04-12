<?php
include_once("conn.php");

if(isset($_POST['register'])){
    $firstname = htmlentities($_POST['fname']);
    $middlename = htmlentities($_POST['mname']);
    $lastname = htmlentities($_POST['lname']);
    $email = htmlentities($_POST['email']);
    $user = htmlentities($_POST['uname']);
    $pass = sha1($_POST['pword']);
	$address = htmlentities($_POST['address']);

    // Check if email or username already exists
    $checkEmail = $conn->prepare("SELECT * FROM customer_tbl WHERE cusEmail = :mail");
    $checkEmail->bindParam(":mail", $email);
    $checkEmail->execute();

    $checkUsername = $conn->prepare("SELECT * FROM customer_tbl WHERE cusUsername = :uname");
    $checkUsername->bindParam(":uname", $user);
    $checkUsername->execute();

    if($checkEmail->rowCount() > 0){
        echo "<script>alert('Email already exists!')</script>";
        echo "<script>window.open('adduser.php','_self')</script>";
    } elseif($checkUsername->rowCount() > 0){
        echo "<script>alert('Username already exists!')</script>";
        echo "<script>window.open('adduser.php','_self')</script>";
    } else {
	// process image
	//filename
	$imgFile = $_FILES['pictureko']['name'];
	//filesize
	$imgSize = $_FILES['pictureko']['size'];
	//temporary name
	$temp_name = $_FILES['pictureko']['tmp_name'];
	//file extension
	$imgExt = pathinfo($imgFile,PATHINFO_EXTENSION);
	
	$valid_ext = array('jpg', 'jpeg', 'png', 'gif');
	
	$newname = rand(1000,10000000).".".$imgExt;
	
	$upload_dir = "photos/";
	
	if(in_array($imgExt,$valid_ext)){
		if($imgSize < 5000000){
			move_uploaded_file($temp_name,$upload_dir.$newname);
			
			$statement = $conn->prepare("INSERT INTO customer_tbl (cusFname, cusMname, cusLname, cusEmail, cusUsername, cusPassword, cusAddress, cusPicture) VALUES (:pangalan,:panggitna,:apelyido,:mail, :palayaw, :lihim, :bahay, :img)");
			$statement->bindParam(":pangalan",$firstname);
			$statement->bindParam(":panggitna",$middlename);
			$statement->bindParam(":apelyido",$lastname);
			$statement->bindParam(":mail",$email);
			$statement->bindParam(":palayaw",$user);
			$statement->bindParam(":lihim",$pass);
			$statement->bindParam(":bahay",$address);
			$statement->bindParam(":img",$newname);
			$statement->execute();

			echo "<script>alert('Successfully Uploaded!')</script>";
			echo "<script>window.open('adduser.php','_self')</script>";
		} else {
			echo "<script>alert('Sorry, your file is too large!')</script>";
			echo "<script>window.open('adduser.php','_self')</script>";
		}
	} else {
		echo "<script>alert('Sorry, only jpeg, jpg, png and gif is allowed!')</script>";
		echo "<script>window.open('adduser.php','_self')</script>";
	}
}
}
?>