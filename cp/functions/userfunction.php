<?php 
include('db/config.php');

function redirect($url,$message)
{
    $_SESSION['message']=$message;
    header('Location:'.$url);
    exit();
}
function getAll($table)
{
    global $conn;
    $query="SELECT * FROM $table";
   return $result=mysqli_query($conn,$query);
}
function getId($table,$id)
{
    global $conn;
    $query="SELECT * FROM $table WHERE p_id='$id'";
   return $result=mysqli_query($conn,$query);
}
function getcolName($table,$name)
{
    global $conn;
    $query="SELECT * FROM $table WHERE colName='$name' LIMIT 1";
   return $result=mysqli_query($conn,$query);
}
function getproductName($table,$name)
{
    global $conn;
    $query="SELECT * FROM $table WHERE p_name='$name' LIMIT 1";
   return $result=mysqli_query($conn,$query);
}
function getProductByCollection($cid){
    global $conn;
    $query="SELECT * FROM product WHERE collectionID='$cid'";
   return $result=mysqli_query($conn,$query);
}
function getCartItem()
{
    global $conn; 
    $cusID=$_SESSION['auth_user']['c_id'];
    $sql="SELECT c.cart_id as cID,c.pqty,c.p_id,p.p_id as pID,p.p_name,p.p_size,p.p_image,p.p_price
    FROM carts c, product p WHERE c.p_id=p.p_id AND c.c_id='$cusID' ORDER BY c.cart_id DESC";
    return $result=mysqli_query($conn,$sql);
}


function getWishItem()
{
    global $conn;
    $cusID=$_SESSION['auth_user']['c_id'];
    $sql="SELECT w.wish_id as wID,w.p_id,p.p_id as pID,p.p_name,p.p_size,p.p_image,p.p_price
    FROM wishList w,product p WHERE w.p_id=p.p_id AND w.c_id='$cusID' ORDER BY w.wish_id DESC";
    return $result=mysqli_query($conn,$sql);
}
function getOrderItems()
{
    global $conn;
    $cusID=$_SESSION['auth_user']['c_id'];
    $sql="SELECT * FROM `Order` WHERE c_id='$cusID' ORDER BY o_id DESC";
   return $result=mysqli_query($conn,$sql);
}
function checkTrackingNo($trackingNumber)
{
    global $conn;
    $cusID=$_SESSION['auth_user']['c_id'];
    $sql="SELECT * FROM `Order` WHERE tracking_no='$trackingNumber' AND c_id='$cusID'";
    return $result=mysqli_query($conn,$sql);
}
function getAllCol($table)
{
    global $conn;
    $query="SELECT * FROM $table";
    return $result=mysqli_query($conn,$query);
}

function getColId($table,$id)
{
    global $conn;
    $query="SELECT * FROM $table WHERE collectionID='$id'";
   return $result=mysqli_query($conn,$query);
}

if(isset($_POST['submit']))
{
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $mail=mysqli_real_escape_string($conn,$_POST['mail']);
    $phone=mysqli_real_escape_string($conn,$_POST['phone']);
    $address=mysqli_real_escape_string($conn,$_POST['address']);
    $pass=mysqli_real_escape_string($conn,$_POST['pass']);
    $cpass=mysqli_real_escape_string($conn,$_POST['cpass']);

    $checkemail="SELECT c_email FROM customer WHERE c_email='$mail' ";
    $checkemailQuery=mysqli_query($conn,$checkemail);
    if($pass==$cpass)
    {
        $sql="INSERT INTO customer (c_name,c_email,c_phone,c_address,c_password) VALUES 
        ('$name','$mail','$phone','$address','$pass')";
        $query=mysqli_query($conn,$sql);
        if($query)
        {
            redirect('loginUi.php',"Registered Successfully");
        }
        else
        {
            redirect('register.php',"something went worng");
        }
    }
    else
    {
        redirect('register.php',"Password does not match");
    }

}
if(isset($_POST['product_btn']))
{
    $productID=mysqli_real_escape_string($conn,$_POST['collectionID']);
    $sql="SELECT p.*, c.colName FROM product p JOIN collection c ON p.collectionID = c.collectionID WHERE p.collectionID = '$productID'";
    $res=mysqli_query($conn,$sql);
    $data=mysqli_fetch_array($res);
    if($data){

        redirect('christianDior.php',"Category deleted successfully");
    }
    else
    {
        redirect('index.php',"Something Went wrong");
    }
}
?>