<?php
session_start();
 include('include/header.php');
 include('functions/userfunction.php');
 if(isset($_GET['product']))
{
    $productName=$_GET['product'];
    $productData=getproductName("product",$productName);
    $product=mysqli_fetch_array($productData);
    if($product)
    {
    ;
        
        ?>
<div class="py-3">
    <div class="container">
        <h6 class="text-black">
            <a class="text-black" href="index.php">
            Home/
            </a>
            
            <a class="text-black" href="product.php?<?=$product['colName'];?>">
            
            </a>
            <?=$product['p_name'];?>
        </h6>
    </div>
</div>

<div class="container mt-3 product_data" id="<?=$product['p_id']?>">
        <div class="row">
            <div class="col-md-4">
                <img src="upload/<?=$product['p_image']?>" alt="<?=$product['p_name']?>" class="w-100">
            </div>
            <div class="col-md-8">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h4><?=$product['p_name']?></h4>
                        <hr> 
                    </div>
                    <div class="col-md-6">
                    <button class="btn wish" value="<?=$product['p_id']?>"><i class="fa bi bi-heart"></i></button>   
                    </div>
                </div>
                <p><?=$product['p_note']?></p>
                
                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                <label class="btn btn-secondary" for="option1"><?=$product['p_size']?></label>
                <!-- <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                <label class="btn btn-secondary" for="option2"><?=$product['p_size']?></label> -->
                <h6>Description:</h6>
                <p><?=$product['p_description']?></p>
                <h6>Ingredients</h6>
                <p><?=$product['p_ingredients']?></p>
                <div class="col-md-12">
                    <!-- <button class="btn btn-dark">Buy$</button> -->
                </div>
                
                <!-- start of offcanvas -->
                <div class="input-group mb-3" style="width:140px">
                    <button class="input-group-text decrement-btn ">-</button>
                    <input type="text" class="form-control text-center bg-white qty" value="1">
                    <button class="input-group-text increment-btn ">+</button>
                </div>
                

                <button class="btn btn-dark add-to-bag-btn" value="<?=$product['p_id']?>" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <span>ADD</span>
                <span class="priceBtn">Buy$ <?=$product['p_price']?></span>
                </button>
                 
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="myCart">
                    <h5 class="text-center">Cart</h5>
                    <?php

                $items=getCartItem();
                $cartTotal=0;
                $totalPrice=0;
                if(mysqli_num_rows($items)>0){
                foreach($items as $cartItem){
                    $totalPrice += $cartItem['p_price'] * $cartItem['pqty'];
                                    if ($totalPrice > 0) {
                                        $cartTotal += $totalPrice;
                                    }
                    ?>
                <div class="row cartItem" id="<?=$cartItem['p_id']?>">
            <div class="col-md-4">
                <img src="upload/<?=$cartItem['p_image']?>" alt="<?=$cartItem['p_name']?>" class="w-100">
            </div>
            <div class="col-md-8">
                <div class="row mt-2">
                    <div class="col-md-3x">
                        <h6><?=$cartItem['p_name']?></h6> 
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3x">
                    <h6>Size:<?=$cartItem['p_size']?></h6>
                    <h6>Price: $<?=$cartItem['p_price']?></h6> 
                    <div class="input-group mb-3" style="width:140px">
                    <button class="input-group-text decrement-btn updateQuantity">-</button>
                    <input type="text" class="form-control text-center bg-white qty cartQty" value="<?=$cartItem['pqty']?>">
                    <button class="input-group-text increment-btn updateQuantity">+</button>
                </div>
                    <!-- <h6>Quantity:<?=$cartItem['pqty']?></h6>  -->
                 
                   <?php
                    if($cartItem['pqty'] > 1)
                    {
                        ?>
                        <h6>Total Price:$<?=$totalPrice?>.00</h6> 
                        
                        <?php
                        $totalPrice=0;
                    }
                    else{
                        $totalPrice=0;
                    }
                   ?>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-danger removeItem" value="<?=$cartItem['cID']?>">Remove</button>
                </div>
               
                
                </div><hr class="mt-2">
                </div>
                <?php  
                } 
                }
            
                else{?>
                    <div class="card card-body shadow text-center">
                        <h4 class="py-3">Your cart is empty </h4>
                    </div>
                    <?php
                }
                ?>
<!-- End of Offcanvas -->
 <!-- Responsive Canvas -->
<!-- <button class="btn btn-dark d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
<span></span>
</button> -->

<div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasResponsiveLabel"></h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p class="mb-0"></p>
  </div>
</div>
 <!-- END of responsive -->
 
</div>
<a href="checkOut.php" value="<?=$product['p_id']?>" class="btn btn-outline-primary checkOut">Proceed to Check Out $<?=$cartTotal?></a>
        </div>
        
        <!-- Related Products -->
        
    </div>

    <?php   
    }
    else{
        echo "Products Not Availabe";
    }
} 
else{
    echo "Something Went Wrong";
}


include('include/footer.php');
?>

