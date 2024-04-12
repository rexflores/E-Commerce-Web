<?php
include_once("session.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Add Product</title>

    <style>
        body {
				font-family: 'Arial', sans-serif;
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

            textarea[name="description"] {
            width: calc(100% - 20px); /* Adjust as needed */
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            <h1>Add Product</h1>
            <a class="viewrec" href="viewproducts.php">View Products</a><br><br>
        </div>

        <div class="contents">
            <form action="registerproduct.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Product Name</td>
                        <td><input type="text" name="productName" placeholder="Enter Product Name" required></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name="description" rows="5" placeholder="Enter Description" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type="text" name="productPrice" placeholder="Enter Price" required></td>
                    </tr>
                    <tr>
                        <td>Picture</td>
                        <td><input type="file" name="productPicture" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="add_product" value="Add Product"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
