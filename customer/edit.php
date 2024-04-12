<?php
include_once("conn.php");
include_once("session.php");

$uid = $_SESSION['cid'];

$query = $conn->prepare("SELECT * FROM customer_tbl WHERE cusID = :id");
$query->bindParam(":id", $uid);
$query->execute();

while ($data = $query->fetch()) {
    $firstname = $data['cusFname'];
    $middlename = $data['cusMname'];
    $lastname = $data['cusLname'];
    $email = $data['cusEmail'];
    $username = $data['cusUsername'];
	$picture = $data['cusPicture'];
	$empPass = $data['cusPassword'];
	$address = $data['cusAddress'];
}

if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
	$imgOld = $_POST['oldpic'];
    $passw = $_POST['pword'];
	$addr = $_POST['address'];
    
    // Check if password is provided and not empty
    if (!empty($passw)) {
        $hashedPass = sha1($_POST['pword']);
    } else {
        // If password is not provided, use the existing hashed password
        $hashedPass = $empPass;
    }
	
	// Check if email or username already exists, excluding the current user
	$checkEmail = $conn->prepare("SELECT * FROM customer_tbl WHERE cusEmail = :mail AND cusID != :id");
	$checkEmail->bindParam(":mail", $email);
	$checkEmail->bindParam(":id", $uid);
	$checkEmail->execute();

	$checkUsername = $conn->prepare("SELECT * FROM customer_tbl WHERE cusUsername = :uname AND cusID != :id");
	$checkUsername->bindParam(":uname", $uname);
	$checkUsername->bindParam(":id", $uid);
	$checkUsername->execute();

	if($checkEmail->rowCount() > 0){
		echo "<script>alert('Email already exists!')</script>";
		echo "<script>window.open('edit.php?uid=' . $uid, '_self')</script>";
	} elseif ($checkUsername->rowCount() > 0){
		echo "<script>alert('Username already exists!')</script>";
		echo "<script>window.open('edit.php?uid=' . $uid, '_self')</script>";
	} else {
		
		// process image
		//filename
	
		$imgFile = $_FILES['pictureko']['name'];
	
		if($imgFile != ''){
			$updated_img = $_FILES['pictureko']['name'];
			//filesize
			$imgSize = $_FILES['pictureko']['size'];
			//temporary name
			$temp_name = $_FILES['pictureko']['tmp_name'];
			//file extension
			$imgExt = pathinfo($updated_img, PATHINFO_EXTENSION);
			
			$valid_ext = array('jpg', 'jpeg', 'png', 'gif');
			
			$newname = rand(1000,10000000).".".$imgExt;
			
			$upload_dir = "../admin/photos/";
		
			if(in_array($imgExt,$valid_ext)){
				if($imgSize < 5000000){
					// delete old picture only if the new image is successfully uploaded
					if (file_exists("../admin/photos/" . $imgOld)) {
						unlink("../admin/photos/" . $imgOld);
					}

					move_uploaded_file($temp_name, $upload_dir . $newname);
				
					echo "<script>alert('Successfully Updated')</script>";
					echo "<script>window.open('index.php', '_self')</script>";
					
					// Update the database with the new information, including the new picture name
					$update = $conn->prepare("UPDATE customer_tbl SET cusFname = :una, cusMname = :dalawa, cusLname = :tatlo, cusEmail = :mail, cusUsername = :usern, cusPassword = :pass, cusAddress = :bahay, picture = :img WHERE cusID = :id");
					$update->bindParam(":una", $fname);
					$update->bindParam(":dalawa", $mname);
					$update->bindParam(":tatlo", $lname);
					$update->bindParam(":mail", $email);
					$update->bindParam(":usern", $uname);
					$update->bindParam(":pass", $hashedPass);
					$update->bindParam(":bahay", $addr);
					$update->bindParam(":img", $newname);
					$update->bindParam(":id", $uid);
					$update->execute();

				} else {
					echo "<script>alert('Sorry, your file is too large!')</script>";
					echo "<script>window.open('edit.php?uid=' . $uid, '_self')</script>";
				}
			
			} else {
				echo "<script>alert('Sorry, only jpeg, jpg, png and gif is allowed!')</script>";
				echo "<script>window.open('edit.php?uid=' . $uid, '_self')</script>";
			}

		} else {;
			$newname = $imgOld;
			
			echo "<script>alert('Successfully Updated')</script>";
			echo "<script>window.open('index.php', '_self')</script>";
			
			// Update the database with the new information, including the new picture name
			$update = $conn->prepare("UPDATE customer_tbl SET cusFname = :una, cusMname = :dalawa, cusLname = :tatlo, cusEmail = :mail, cusUsername = :usern, cusPassword = :pass, cusAddress = :bahay, cusPicture = :img WHERE cusID = :id");
			$update->bindParam(":una", $fname);
			$update->bindParam(":dalawa", $mname);
			$update->bindParam(":tatlo", $lname);
			$update->bindParam(":mail", $email);
			$update->bindParam(":usern", $uname);
			$update->bindParam(":pass", $hashedPass);
			$update->bindParam(":bahay", $addr);
			$update->bindParam(":img", $newname);
			$update->bindParam(":id", $uid);
			$update->execute();
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<title>Edit User</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				background-color: #f8f8f8;
				margin: 0;
				padding: 0;
			}

			.container {
				width: 50%;
				margin: 20px auto;
				background-color: #fff;
				padding: 20px;
				border-radius: 10px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			}

			.header {
				text-align: center;
				margin-bottom: 20px;
			}

			.header h1 {
				color: #333;
			}

			.contents {
				padding: 20px;
			}

			table {
				width: 100%;
			}

			table td {
				padding: 10px;
			}

			input[type="text"],
			input[type="email"],
			input[type="password"],
			input[type="file"] {
				width: calc(100% - 20px);
				padding: 8px;
				margin: 8px 0;
				margin-bottom: 10px;
				box-sizing: border-box;
				border: 1px solid #ccc;
				border-radius: 5px;
			}

			input[type="submit"] {
				background-color: #4caf50;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			input[type="submit"]:hover {
				background-color: #45a049;
			}

			a {
				text-decoration: none;
				font-weight: bold;
				color: #3498db;
			}

			a:hover {
				text-decoration: underline;
			}

			img {
				margin-top: 10px;
				border-radius: 4px;
			}

			/* Responsive Design */
			@media screen and (max-width: 600px) {
				.container {
					width: 90%;
				}
			}
		</style>
	</head>
	<body>

	<div class="container">
			<div class="header">
				<h1>Update Account Information</h1>
			</div>

			<div class="contents">
	
				<form action="" method="post" enctype="multipart/form-data" onsubmit="return validatePassword()">
					<table>
						<tr>
							<td>Firstname</td>
							<td><input type="text" name="fname" value="<?php echo $firstname;?>" required></td>
						</tr>
						<tr>
							<td>Middlename</td>
							<td><input type="text" name="mname" value="<?php echo $middlename;?>" required></td>
						</tr>
						<tr>
							<td>Lastname</td>
							<td><input type="text" name="lname" title="Accept 3" value="<?php echo $lastname;?>" required></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><input type="email" name="email" value="<?php echo $email;?>" required></td>
						</tr>
						<tr>
							<td>Username</td>
							<td><input type="text" name="uname" value="<?php echo $username;?>" required></td>
						</tr>
						<tr>
							<td>Password</td>
							<td><input type="password" name="pword" id="password" placeholder="Enter your Password"></td>
						</tr>
						<tr>
							<td>Confirm Password</td>
							<td>
								<input type="password" name="confirm_pword" id="confirmPassword" placeholder="Confirm your Password">
								<input type="checkbox" onclick="showPassword()"> Show Password
							</td>
						</tr>
						<tr>
							<td>Address</td>
							<td><input type="text" name="address" id="address" value="<?php echo $address;?>" required></td>
						</tr>
						<tr>
							<td>Picture</td>
							<td><input type="file" name="pictureko" accept="image/*">
							<br>
							<input type="hidden" name="oldpic" value="<?php echo $picture;?>">
							<img src="../admin/photos/<?php echo $picture;?>" width="100" height="100"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="update" value="Update Records"></td>
						</tr>
					</table>

					<script>
						// JavaScript function to validate password and confirm password
						function validatePassword() {
							var password = document.getElementById("password").value;
							var confirmPassword = document.getElementById("confirmPassword").value;

							if (password != confirmPassword) {
								alert("Passwords do not match. Please enter matching passwords.");
								return false;
							}
							return true;
						}

						// JavaScript function to toggle password visibility
						function showPassword() {
							var passwordInput = document.getElementById("password");
							var confirmPasswordInput = document.getElementById("confirmPassword");

							if (passwordInput.type === "password") {
								passwordInput.type = "text";
								confirmPasswordInput.type = "text";
							} else {
								passwordInput.type = "password";
								confirmPasswordInput.type = "password";
							}
						}
					</script>
				</form>
			</div>
		</div>
	</body>
</html>