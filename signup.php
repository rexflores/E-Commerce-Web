<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<title>Signup</title>

		<style>
			body {
				font-family: 'Arial', sans-serif;
				background-image: url('logo/banner.png'); /* Specify the path to your background image */
				background-size: cover;
				background-position: center;
				margin: 0;
				padding: 0;
				display: flex;
				justify-content: center;
				align-items: center;
				backdrop-filter: blur(10px); /* Add a blur effect to the background */
			}

			.container {
				width: 50%;
				background-color: rgba(255, 255, 255, 0.8); /* Adjust the opacity of the background color */
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

			.viewrec {
				text-decoration: none;
				color: #3498db;
				font-weight: bold;
			}

			.viewrec:hover {
				text-decoration: underline;
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
				padding: 10px;
				margin: 8px 0;
				display: inline-block;
				box-sizing: border-box;
				border: 1px solid #ccc;
				border-radius: 5px;
			}

			input[type="submit"] {
				background-color: #4CAF50;
				color: white;
				padding: 12px 20px;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			input[type="submit"]:hover {
				background-color: #45a049;
			}

			/* Responsive styling */
			@media (max-width: 600px) {
				.container {
					width: 90%;
				}
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="header">
				<h1>Signup</h1>
			</div>

			<div class="contents">
				<form action="validate.php" method="post" enctype="multipart/form-data" onsubmit="return validatePassword()">
					<table>
						<tr>
							<td>Firstname</td>
							<td><input type="text" name="fname" placeholder="Enter your Firstname" required>
						</tr>
						<tr>
							<td>Middlename</td>
							<td><input type="text" name="mname" placeholder="Enter your Middlename" required>
						</tr>
						<tr>
							<td>Lastname</td>
							<td><input type="text" name="lname" title="Accept 3" placeholder="Enter your Lastname" required>
						</tr>
						<tr>
							<td>Email</td>
							<td><input type="email" name="email" placeholder="Enter your Email" required>
						</tr>
						<tr>
							<td>Username</td>
							<td><input type="text" name="uname" placeholder="Enter your Username" required>
						</tr>
						<tr>
							<td>Password</td>
							<td><input type="password" name="pword" id="password" placeholder="Enter your Password" required></td>
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
							<td><input type="text" name="address" id="address" placeholder="Enter your address" required></td>
						</tr>
						<tr>
							<td>Picture</td>
							<td><input type="file" name="pictureko" accept="image/*" required>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="register" value="Click to Register">
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
				<p>Already have an account? <a href="login.php">Click Here</a></p>
			</div>
		</div>
	</body>
</html>