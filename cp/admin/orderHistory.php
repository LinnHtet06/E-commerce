<?php
session_start();
include('template/header.php');
include('../functions/myfunction.php');
?>

<div class="container">
<div class="row">
        <div class="col-md-12">
            <div class="card">
               <div class="card-header bg-primary">
                <h4>Order History
                    <a href="order.php" class="btn btn-warning float-end">Back</a>
                </h4>
               </div>  
               <div class="card-body" id="">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Tracking Number</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $orders=getOrderHistory();
                    if(mysqli_num_rows($orders)>0)
                    {
                        foreach($orders as $item)
                        {
                            ?>
                            <tr>
                                <td><?=$item['o_id']?></td>
                                <td><?=$item['name']?></td>
                                <td><?=$item['tracking_no']?></td>
                                <td><?=$item['o_totalAmount']?></td>
                                <td><?=$item['created_at']?></td>
                                <td>
                                    <a href="viewOrder.php?t=<?=$item['tracking_no'];?>" class="btn btn-dark">View Details</a>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                    else
                    {
                        ?>
                            <tr>
                                <td colspan="5">No orders yet</td>
                            </tr>
                        <?php
                    }
                ?>
                        
                    </tbody>
                </table>
                </div>
               </div>
                
            </div>
        </div>
    </div>
</div>
                </body>
<?php
include('template/footer.php');
?>