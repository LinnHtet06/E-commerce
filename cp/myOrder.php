<?php
session_start();
include('functions/userfunction.php');
include('include/header.php');

?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    ...
  </div>
</div>
<div class="py-3">
    <div class="container">
        <h6 class="text-black">
            <a class="text-black" href="index.php">
            Home/
            </a>
            
            <a class="text-black" href="myOrder.php">
            MyOrders/
            </a>
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="">
            <div class="row">
               <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tracking Number</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $orders=getOrderItems();
                    if(mysqli_num_rows($orders)>0)
                    {
                        foreach($orders as $item)
                        {
                            ?>
                            <tr>
                                <td><?=$item['o_id']?></td>
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

<?php
include('include/footer.php');
?>