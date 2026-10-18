<?php

session_start();
include('../db/config.php');
include('../functions/myfunction.php');

if(isset($_POST['addCategory']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $stockqty = mysqli_real_escape_string($conn, $_POST['stockqty']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $productionDate = mysqli_real_escape_string($conn, $_POST['productionDate']);
    $expirationDate = mysqli_real_escape_string($conn, $_POST['expirationDate']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image=$_FILES['image']['name'];
    $path="../upload";
    $image_ext=pathinfo($image,PATHINFO_EXTENSION);
    $fileName=time().'.'.$image_ext;
    $colID=mysqli_real_escape_string($conn,$_POST['collectionID']);



$category="INSERT INTO product (p_name,p_price,p_description,p_image,p_stock,p_note,p_category,p_productionDate,p_expirationDate,p_size,p_ingredients,collectionID) VALUES
('$name','$price','$description','$fileName','$stockqty','$note','$category','$productionDate','$expirationDate','$size','$ingredients','$colID')";

$categoryData=mysqli_query($conn,$category);
			if($categoryData) {
				move_uploaded_file($_FILES['image']['tmp_name'],$path.'/'.$fileName);
                $_SESSION['message']="Inserted Successfully";
                redirect('addCategory.php',"Category Added Successfully");
            }
            else{
                redirect('index.php',"Something Went Wrong");
            }
}
elseif(isset($_POST['updateCategory']))
{
    $categoryID=$_POST['categoryID'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $stockqty = mysqli_real_escape_string($conn, $_POST['stockqty']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $productionDate = mysqli_real_escape_string($conn, $_POST['productionDate']);
    $expirationDate = mysqli_real_escape_string($conn, $_POST['expirationDate']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $newImage=$_FILES['image']['name'];
    $oldImage=$_POST['oldImage'];

    if($newImage!="")
    {
        // $updateFilename=$newImage;
        $image_ext=pathinfo($newImage,PATHINFO_EXTENSION);
        $updateFilename=time().'.'.$image_ext;
    }
    else
    {
        $updateFilename=$oldImage;
    }
    $path="../upload";
    $updateQuery="UPDATE product SET p_name='$name',p_price='$price',p_description='$description',p_image='$updateFilename',
    p_stock='$stockqty',p_note='$note',p_category='$category',p_productionDate='$productionDate',p_expirationDate='$expirationDate',
    p_size='$size',p_ingredients='$ingredients' WHERE p_id='$categoryID' ";
    $updateReturn=mysqli_query($conn,$updateQuery);
    if($updateReturn)
    {
        if($_FILES['image']['name']!="")
        {
            move_uploaded_file($_FILES['image']['tmp_name'],$path.'/'.$updateFilename);
            if(file_exists("../upload/".$oldImage))
            {
                unlink("../upload/".$oldImage);
            }
        }
        redirect("editCategory.php?id=$categoryID","Category is updated successfully");
    }
    else
    {
        redirect("editCategory.php?id=$categoryID","Something Went wrong");
    }
}

elseif(isset($_POST['deleteBtn']))
{
    $categoryId=mysqli_real_escape_string($conn,$_POST['p_id']);
    $sql="SELECT * FROM product WHERE p_id='$categoryId' ";
    $res=mysqli_query($conn,$sql);
    $data=mysqli_fetch_array($res);
    $image=$data['p_image'];
    $deleteQuery="DELETE FROM product where p_id='$categoryId' ";
    $result=mysqli_query($conn,$deleteQuery);
    if($result)
    {
        if(file_exists("../upload/".$image))
            {
                unlink("../upload/".$image);
            }
        redirect('addCategory.php',"Category deleted successfully");
    }
    else
    {
        redirect('addCategory.php',"Something Went wrong");
    }
}


elseif(isset($_POST['addCollection']))
{
    $collectionID=mysqli_real_escape_string($conn, $_POST['collectionID']);
    $collectionName = mysqli_real_escape_string($conn, $_POST['colName']);
    $description = mysqli_real_escape_string($conn, $_POST['colDescription']);
    $limitedEdition = mysqli_real_escape_string($conn, $_POST['Lte'])?"1":"0";
    $image=$_FILES['image']['name'];
    $path="../upload";
    $image_ext=pathinfo($image,PATHINFO_EXTENSION);
    $fileName=time().'.'.$image_ext;
    
$collection="INSERT INTO collection (collectionID,colname,coldescription,limitedEdition,colImage) VALUES ('$collectionID','$collectionName','$description','$limitedEdition','$fileName')";


$colData=mysqli_query($conn,$collection);
			if($colData) {
				move_uploaded_file($_FILES['image']['tmp_name'],$path.'/'.$fileName);
                $_SESSION['message']="Inserted Successfully";
                redirect('addCollection.php',"Collection Added Successfully");
            }
            else{
                redirect('index.php',"Something Went Wrong");
            }
}

elseif(isset($_POST['editCollection']))
{
    $colID=$_POST['colID'];
    $colName = mysqli_real_escape_string($conn, $_POST['colName']);
    $colDescription = mysqli_real_escape_string($conn, $_POST['colDescription']);
    $limitedEdition = isset($_POST['Lte']) ? '1':'0';
    $newImage=$_FILES['image']['name'];
    $oldImage=$_POST['oldImage'];

    if($newImage!="")
    {
        // $updateFilename=$newImage;
        $image_ext=pathinfo($newImage,PATHINFO_EXTENSION);
        $updateFilename=time().'.'.$image_ext;
    }
    else
    {
        $updateFilename=$oldImage;
    }
    $path="../upload";
   
    $updateQuery="UPDATE collection SET colName='$colName',colDescription='$colDescription',limitedEdition='$limitedEdition',colImage='$updateFilename' WHERE collectionID='$colID' ";
    $updateReturn=mysqli_query($conn,$updateQuery);
    if($updateReturn)
    {
        if($_FILES['image']['name']!="")
        {
            move_uploaded_file($_FILES['image']['tmp_name'],$path.'/'.$updateFilename);
            if(file_exists("../upload/".$oldImage))
            {
                unlink("../upload/".$oldImage);
            }
        }
        redirect("editCollection.php?id=$colID","Collection is updated successfully");
    }
    else
    {
        redirect("editCollection.php?id=$colID","Something Went wrong");
    }
   
}

elseif(isset($_POST['deleteColBtn']))
{
    $colID=mysqli_real_escape_string($conn,$_POST['collectionID']);
    $sql="SELECT * FROM collection WHERE collectionID='$colID' ";
    $res=mysqli_query($conn,$sql);
    $data=mysqli_fetch_array($res);
    
    $deleteQuery="DELETE FROM collection where collectionID='$colID' ";
    $result=mysqli_query($conn,$deleteQuery);
    if($result)
    {
        if(file_exists("../upload/".$image))
            {
                unlink("../upload/".$image);
            }
        redirect('addCollection.php',"Category deleted successfully");
    }
    else
    {
        redirect('addCollection.php',"Something Went wrong");
    }
}
elseif(isset($_POST['updateOrderBtn']))
{
    $trackingNumber=$_POST['trackingNumber'];
    $status=$_POST['orderStatus'];
    $sql="UPDATE `Order` SET status='$status' WHERE tracking_no='$trackingNumber' ";
    $result=mysqli_query($conn,$sql);

    redirect("viewOrder.php?t=$trackingNumber","Order Status updated successfully");
}
else
{
    header('Location:../index.php');
}
?>