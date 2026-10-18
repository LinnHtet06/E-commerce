<?php
session_start();
include('functions/userfunction.php');
include('include/header.php');
// include('functions/authCode.php');
?>
<div class="py-3">
    <div class="container">
        <h6 class="text-black">
            <a class="text-black" href="index.php">
            Home/
            </a>
            
            <a class="text-black" href="checkOut.php">
            CheckOut/
            </a>
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container product_data">
        <div class="card">
            <div class="card-body shadow">
            <form action="functions/placeOrder.php" method="POST">
            <div class="row">
                <div class="col-md-7">
                    <h5>Detail</h5><hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label  class="fw-bold">Name</label>
                            <input type="text" required name="name" id="name" placeholder="Enter your full Name" class="form-control" id="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="fw-bold">Email</label>
                            <input type="email" required name="email" id="email" placeholder="Enter your email" class="form-control" id="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="fw-bold">Phone</label>
                            <input type="text" required  name="phone" id="phone" placeholder="Enter your Phone Number" class="form-control" id="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="fw-bold">Postal Code (optional)</label>
                            <input type="text" name="pincode" id="pincode" placeholder="Enter your pin code" class="form-control" id="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="fw-bold">Address</label>
                            <textarea required name="address" id="address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h5>Cart Items</h5><hr>
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <h6>Product</h6>
                        </div>
                        <div class="col-md-3">
                            <h6>Price</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Quantity</h6>
                        </div>
                    </div>
                    <?php 
                    $items=getCartItem();
                    $totalPrice=0;
                    foreach($items as $item)
                    {
                        ?>
                        <div class="card product_data shadow-sm mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                <img src="upload/<?=$item['p_image']?>" alt="<?=$item['p_name']?>" class="w-100">
                                </div>
                                <div class="col-md-3">
                                    <h5><?= $item['p_name']?></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>$<?= $item['p_price']?></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5><?= $item['pqty']?></h5>
                                </div>
                               
                            </div>
                        </div>
                        <?php
                        $totalPrice+=$item['p_price']*$item['pqty'] ;
                    }
                    ?>
                    <hr>
                    <h5>Total Price: <span class="float-end fw-bold">$<?= $totalPrice?></span></h5>
                    <div>
                        <input type="hidden" name="paymentMode" value="card">
                        <button name="placeOrder-btn" type="submit" class="btn btn-dark w-100">
                            Place Order $<?= $totalPrice?></button>
                            <div id="paypal-button-container" class="mt-3"></div>
                    </div>
                </div>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<?php
include('include/footer.php');
?>
 <!-- <script src="https://www.paypal.com/sdk/js?client-id=AWm8cErp2CpUE91SYJ9yuMAPSt7DaZGbQeM1x971DTfmJlFeZv3rmrmSpADwEA-HC1c6AzlJXpgfAMgP&components=buttons&enable-funding=card&disable-funding=paylater,venmo" data-sdk-integration-source="integrationbuilder_sc"></script> -->
 