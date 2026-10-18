<?php
session_start();
include('template/header.php');
include('../functions/myfunction.php');

if(isset($_GET['t']))
{
    $trackingNumber=$_GET['t'];
    $orderData=checkTrackingNo($trackingNumber);
    if(mysqli_num_rows($orderData)<0)
    {
        ?>
        <h5>Something Went Wrong</h5>
        <?php
        die();
    }
}
else
{
    ?>
    <h5>Something Went Wrong</h5>
    <?php
    die();
}
$data=mysqli_fetch_array($orderData);
?>


    <div class="container">
            <div class="row">
               <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="fs-3 fw-bold">View Order</span>
                            <a href="order.php" class="btn btn-warning float-end"><i class="fa fa-reply"></i>Back</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Delivery Details</h4><hr>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Name</label>
                                            <div class="border p-1">
                                            <?= $data['name'];?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Email</label>
                                            <div class="border p-1">
                                            <?= $data['email'];?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Phone</label>
                                            <div class="border p-1">
                                            <?= $data['phone'];?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Tracking Number</label>
                                            <div class="border p-1">
                                            <?= $data['tracking_no'];?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Address</label>
                                            <div class="border p-1">
                                            <?= $data['address'];?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold">Pin Code</label>
                                            <div class="border p-1">
                                            <?= $data['pincode'];?>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <h4>Order Detials</h4><hr>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                    
                                    $orderSql="SELECT o.o_id as oID,o.tracking_no,o.c_id, oi.*,p.* FROM `Order` o,`OrderItem` oi,product p
                                    WHERE oi.o_id=o.o_id AND p.p_id=oi.p_id AND o.tracking_no='$trackingNumber' ";
                                    $orderResult=mysqli_query($conn,$orderSql);
                                    if(mysqli_num_rows($orderResult)>0)
                                    {
                                        foreach($orderResult as $item)
                                        {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                <img src="../upload/<?=$item['p_image']?>" alt="<?=$item['p_name']?>" width="50px" heigh="50px">
                                                <?=$item['p_name']?>
                                            </td>
                                           <td class="align-middle">
                                                $<?=$item['oi_price']?>
                                           </td>
                                           <td class="align-middle">
                                                <?=$item['oi_quantity']?>
                                           </td>
                                            </tr>
                                            <?php

                                        }
                                    }
                                    
                                    ?>
                                    
                                    </tbody>
                                    </table>
                                    <hr>
                                    <h5>Total Price: <span class="float-end fw-bold">$<?= $data['o_totalAmount']?></span></h5>

                                    <div class=" mb-3">
                                        <label for="">Payment Mode:</label>
                                        <?= $data['payment_mode']?>
                                    </div>

                                    <label class="fw-bold">Status</label>
                                    <div class="mb-3">
                                        <form action="categoryCode.php" method="POST">
                                            <input type="hidden" name="trackingNumber" value="<?= $data['tracking_no']?>">
                                        <select name="orderStatus" class="form-select">
                                            <option value="0"<?= $data['status']==0?"selected":"" ?>>Under Process</option>
                                            <option value="1" <?= $data['status']==1?"selected":"" ?>>Completed</option>
                                            <option value="2" <?= $data['status']==2?"selected":"" ?>>Cancelled</option>
                                        </select>
                                       <button type="submit" name="updateOrderBtn" class="btn btn-primaryk mt-2">Update Status</button>
                                       </form>
                                    </div> 

                                </div>
                            </div>
                        </div>
                    </div>
               
               </div>
                
            </div>
        
</div>

<?php
include('template/footer.php');
?>