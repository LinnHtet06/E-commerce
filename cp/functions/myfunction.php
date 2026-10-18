<?php
include('../db/config.php');
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
function getAllOrderItems()
{
    global $conn;
    $sql="SELECT * FROM `Order` WHERE status='0'";
    return $result=mysqli_query($conn,$sql);
}
function checkTrackingNo($trackingNumber)
{
    global $conn;
    $cusID=$_SESSION['auth_user']['c_id'];
    $sql="SELECT * FROM `Order` WHERE tracking_no='$trackingNumber' ";
    return $result=mysqli_query($conn,$sql);
}
function getOrderHistory()
{
    global $conn;
    $sql="SELECT * FROM `Order` WHERE status !='0'";
    return $result=mysqli_query($conn,$sql);
}
if(isset($_POST['Adminsubmit']))
{
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $mail=mysqli_real_escape_string($conn,$_POST['mail']);
    $gender=mysqli_real_escape_string($conn,$_POST['gender']);
    $pass=mysqli_real_escape_string($conn,$_POST['pass']);
    $cpass=mysqli_real_escape_string($conn,$_POST['cpass']);

    if($pass==$cpass)
    {
    $checkemail="SELECT a_email FROM admin WHERE a_email='$mail' ";
    $checkemailQuery=mysqli_query($conn,$checkemail);
    if (mysqli_num_rows($checkemailQuery) > 0) {
        redirect('adminRegister.php', "Email already exists");
    } 
    else{
        $hashedPass = md5($pass);
        $sql="INSERT INTO admin (a_name,a_email,a_gender,a_password) VALUES 
        ('$name','$mail','$gender','$hashedPass')";
        $query=mysqli_query($conn,$sql);
        if($query)
        {
            redirect('../admin/adminlogin.php',"Registered Successfully");
        }
        else
        {
            redirect('adminRegister.php',"something went worng");
        }
    }
    }
    else
    {
        redirect('adminRegister.php',"Password does not match");
    }

}
?>