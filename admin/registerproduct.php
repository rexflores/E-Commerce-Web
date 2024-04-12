<?php
include_once("conn.php");

if(isset($_POST['add_product'])){
    $productName = htmlentities($_POST['productName']);
    $description = htmlentities($_POST['description']);
    $productPrice = htmlentities($_POST['productPrice']);

    // Check if product already exists
    $checkProduct = $conn->prepare("SELECT * FROM products_tbl WHERE productName = :productName");
    $checkProduct->bindParam(":productName", $productName);
    $checkProduct->execute();

    if($checkProduct->rowCount() > 0){
        echo "<script>alert('Product already exists!')</script>";
        echo "<script>window.open('addproduct.php','_self')</script>";
    } else {
        // Process image upload
        $imgFile = $_FILES['productPicture']['name'];
        $imgSize = $_FILES['productPicture']['size'];
        $temp_name = $_FILES['productPicture']['tmp_name'];
        $imgExt = pathinfo($imgFile, PATHINFO_EXTENSION);
        
        $valid_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        $newname = rand(1000,10000000).".".$imgExt;
        
        $upload_dir = "product_photos/";
        
        if(in_array($imgExt, $valid_ext)){
            if($imgSize < 5000000){
                move_uploaded_file($temp_name, $upload_dir.$newname);
                
                // Insert product details into database
                $statement = $conn->prepare("INSERT INTO products_tbl (productName, description, productPrice, productPicture) VALUES (:productName, :description, :productPrice, :productPicture)");
                $statement->bindParam(":productName", $productName);
                $statement->bindParam(":description", $description);
                $statement->bindParam(":productPrice", $productPrice);
                $statement->bindParam(":productPicture", $newname);
                $statement->execute();
    
                echo "<script>alert('Product details uploaded successfully!')</script>";
                echo "<script>window.open('addproduct.php','_self')</script>";
            } else {
                echo "<script>alert('Sorry, your file is too large!')</script>";
                echo "<script>window.open('addproduct.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Sorry, only jpeg, jpg, png and gif files are allowed!')</script>";
            echo "<script>window.open('addproduct.php','_self')</script>";
        }
    }
}
?>
