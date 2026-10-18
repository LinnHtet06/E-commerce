<?php
session_start();
include('../db/config.php');
if(isset($_SESSION['auth']))
{


    if(isset($_POST['placeOrder-btn']))
    {
        
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $paymentMode = mysqli_real_escape_string($conn, $_POST['paymentMode']);
        $paymentId = 1;

        

        if((empty($name) || empty($email) || empty($phone) || empty($pincode) || empty($address)))
        {
            $_SESSION['message']="All fields are mandatory";
            header('Location: ../checkOut.php');
            exit(0);
        }

        $cusID=$_SESSION['auth_user']['c_id'];
        $sql="SELECT c.cart_id as cID,c.pqty,c.p_id,p.p_id as pID,p.p_name,p.p_size,p.p_image,p.p_price
        FROM carts c, product p WHERE c.p_id=p.p_id AND c.c_id='$cusID' ORDER BY c.cart_id DESC";
         $result=mysqli_query($conn,$sql);
        
        $totalPrice=0;
        foreach($result as $item)
        {
            $totalPrice+=$item['p_price']*$item['pqty'];
        }
      
        $tracking_no="DIOR".rand(1111,9999).substr($phone,2);

        $query="INSERT INTO `Order` (tracking_no,c_id,name,email,phone,address,pincode,o_totalAmount,payment_mode,payment_id) VALUES ('$tracking_no','$cusID','$name','$email','$phone','$address','$pincode','$totalPrice','$paymentMode','$paymentId')";
        $queryResult=mysqli_query($conn,$query);
        if($queryResult)
        {
            $orderId=mysqli_insert_id($conn);
            foreach($result as $orderItem)
            {
               $productId= $orderItem['p_id'];
               $productQty= $orderItem['pqty'];
               $price=$orderItem['p_price'];
               $insertItemQuery="INSERT INTO `OrderItem` (oi_quantity,oi_price,o_id,p_id) VALUES ('$productQty','$price','$orderId','$productId')";
               $insertResult=mysqli_query($conn,$insertItemQuery);

               $productSql="SELECT * FROM product WHERE p_id='$productId' LIMIT 1";
               $productResult=mysqli_query($conn,$productSql);
               $productData=mysqli_fetch_array($productResult);
              $currentStock=$productData['p_stock'];
              $newStock=$currentStock-$productQty;
              $updateStock="UPDATE product SET p_stock='$newStock' WHERE p_id='$productId'";
              $updateStockResult=mysqli_query($conn,$updateStock);
            }
            $deleteCartQuery="DELETE FROM carts WHERE c_id='$cusID'";
            $deleteCartRun=mysqli_query($conn,$deleteCartQuery);
            $_SESSION['message']="Order Placed Successfully";
            header('Location: ../myOrder.php');
            die();
        }
    }
}
else
{
    header('Location: ../index.php');
}
?>