<?php 
session_start();
include('include/header.php');
include('functions/userfunction.php');
?>

<div class="py-3">
<div class="container">
  <h1 class="text-center mt-2">WishList Items</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
      <div id="wish" class="">
    <?php
    if(isset($_SESSION['auth'])){
$items=getWishItem();
foreach($items as $getWishItem){
    ?>
    <div class="col wishlist-item" id="<?=$getWishItem['wID']?>">
    <div class="card" >
    <img src="upload/<?=$getWishItem['p_image']?>" alt="<?=$getWishItem['p_name']?>" class="w-100">
      <div class="card-body">
        <h5 class="card-title"><?=$getWishItem['p_name']?></h5>
        <h5 class="card-title">$<?=$getWishItem['p_price']?></h5>
        <button class="btn btn-danger removeWishList" value="<?=$getWishItem['wID']?>">Remove</button>
      </div>
    </div>
  </div>

  <?php   
}
                }
                else{
                  $_SESSION['message']="No wishlist item, Login to add wishlist";
                }
                ?>
                </div>
                </div>
                </div>
                </div>
    <?php include('include/footer.php');?>
                