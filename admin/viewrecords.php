<?php
include_once("conn.php");
include_once("session.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
		<title>View Users</title>
		<style>
			body {
				font-family: 'Arial', sans-serif;
				margin: 0;
				padding: 0;
				background-color: #f8f8f8;
			}

			.header {
				text-align: center;
				margin-bottom: 20px;
			}

			.header h1 {
				color: #333;
			}

			a {
				text-decoration: none;
			}

			.addrec {
				text-decoration: none;
				color: #3498db;
				font-weight: bold;
			}

			.addrec:hover {
				text-decoration: underline;
			}

			table {
				width: 80%;
				margin: 20px auto;
				border-collapse: collapse;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				background-color: #fff;
			}

			th, td {
				padding: 15px;
				text-align: left;
				border-bottom: 1px solid #ddd;
			}

			th {
				background-color: #3498db;
				color: #fff;
			}

			tbody tr:hover {
				background-color: #f5f5f5;
			}

			img {
				border-radius: 50%;
				max-width: 100%; /* Make images responsive */
				height: auto;
			}

			.edit,
			.delete {
				display: inline-block;
				padding: 5px 10px;
				margin: 5px;
				border-radius: 5px;
				transition: background-color 0.3s;
			}

			.edit:hover {
				background-color: #3498db;
				color: #fff;
			}

			.delete:hover {
				background-color: #e74c3c;
				color: #fff;
			}

			@media screen and (max-width: 768px) {
				table {
					width: 100%;
				}

				th, td {
					display: block;
					width: 100%;
					box-sizing: border-box;
				}

				th {
					text-align: left;
				}
			}
        </style>
	</head>
	<body>

	<div class="container">
			<div class="header">
				<h1>Customer Accounts</h1>
				<a class="addrec" href="adduser.php">Add Customer Account</a><br><br>
				<a class="dashboard" href="index.php">Return to Dashboard</a><br><br>
			</div>

			<div class="contents">
	
				<table border>
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Username</th>
							<th>Address</th>
							<th>Picture</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = $conn->prepare("SELECT * FROM customer_tbl");
						$query->execute();

						while($data = $query->fetch()){
							$firstname = $data['cusFname'];
							$middlename = $data['cusMname'];
							$lastname = $data['cusLname'];
							$email = $data['cusEmail'];
							$username = $data['cusUsername'];
							$addre = $data['cusAddress'];
							$pic = $data['cusPicture'];
							$eid = $data['cusID'];
						
						?>
						<tr>
							<td><?php echo $firstname." ".$middlename." ".$lastname;?></td>
							<td><?php echo $email;?></td>
							<td><?php echo $username;?></td>
							<td><?php echo $addre;?></td>
							<td><img src="photos/<?php echo $pic;?>" alt="profile picture" width="100" height="100"></td>
							<td><a class="edit" href="edit.php?uid=<?php echo $eid;?>">Edit</a> | <a class="delete" href="delete.php?uid=<?php echo $eid;?>" onclick="return confirm('Are you sure?')">Delete</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>