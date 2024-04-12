<?php
include_once("conn.php");
include_once("session.php");

$pid = $_GET['pid'];

$query = $conn->prepare("SELECT * FROM products_tbl WHERE productID = :id");
$query->bindParam(":id", $pid);
$query->execute();

while ($data = $query->fetch()) {
    $productName = $data['productName'];
    $description = $data['description'];
    $productPrice = $data['productPrice'];
    $productPicture = $data['productPicture'];
}

if (isset($_POST['update'])) {
    $pname = $_POST['pname'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $imgOld = $_POST['oldpic'];
    
    $imgFile = $_FILES['pictureko']['name'];
    
    if($imgFile != ''){
        $updated_img = $_FILES['pictureko']['name'];
        $imgSize = $_FILES['pictureko']['size'];
        $temp_name = $_FILES['pictureko']['tmp_name'];
        $imgExt = pathinfo($updated_img, PATHINFO_EXTENSION);
        
        $valid_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        $newname = rand(1000,10000000).".".$imgExt;
        
        $upload_dir = "product_photos/";
    
        if(in_array($imgExt,$valid_ext)){
            if($imgSize < 5000000){
                if (file_exists("product_photos/" . $imgOld)) {
                    unlink("product_photos/" . $imgOld);
                }

                move_uploaded_file($temp_name, $upload_dir . $newname);
                
                echo "<script>alert('Successfully Updated')</script>";
                echo "<script>window.open('viewproducts.php', '_self')</script>";
                
                $update = $conn->prepare("UPDATE products_tbl SET productName = :pname, description = :desc, productPrice = :price, productPicture = :img WHERE productID = :id");
                $update->bindParam(":pname", $pname);
                $update->bindParam(":desc", $desc);
                $update->bindParam(":price", $price);
                $update->bindParam(":img", $newname);
                $update->bindParam(":id", $pid);
                $update->execute();
            } else {
                echo "<script>alert('Sorry, your file is too large!')</script>";
                echo "<script>window.open('editproduct.php?pid=' . $pid, '_self')</script>";
            }
        } else {
            echo "<script>alert('Sorry, only jpeg, jpg, png and gif is allowed!')</script>";
            echo "<script>window.open('editproduct.php?pid=' . $pid, '_self')</script>";
        }
    } else {
        $newname = $imgOld;
        
        echo "<script>alert('Successfully Updated')</script>";
        echo "<script>window.open('viewproducts.php', '_self')</script>";
        
        $update = $conn->prepare("UPDATE products_tbl SET productName = :pname, description = :desc, productPrice = :price, productPicture = :img WHERE productID = :id");
        $update->bindParam(":pname", $pname);
        $update->bindParam(":desc", $desc);
        $update->bindParam(":price", $price);
        $update->bindParam(":img", $newname);
        $update->bindParam(":id", $pid);
        $update->execute();
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

    <title>Edit Product</title>
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
            <h1>Update Product</h1>
            <a href="viewproducts.php">View Products</a> | <a href="addproduct.php">Add Product</a><br><br>
        </div>

        <div class="contents">
    
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Product Name</td>
                        <td><input type="text" name="pname" value="<?php echo $productName;?>" required></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name="desc" rows="4" cols="50" required><?php echo $description;?></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type="text" name="price" value="<?php echo $productPrice;?>" required></td>
                    </tr>
                    <tr>
                        <td>Picture</td>
                        <td><input type="file" name="pictureko" accept="image/*">
                        <br>
                        <input type="hidden" name="oldpic" value="<?php echo $productPicture;?>">
                        <img src="product_photos/<?php echo $productPicture;?>" width="100" height="100"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="update" value="Update Product"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
