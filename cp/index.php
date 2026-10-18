<?php
session_start();
 include('include/header.php');
 include('functions/userfunction.php');
 
	if(isset($_SESSION['message']))
	{?>

	
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong></strong> <?= $_SESSION['message'];?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php
  unset($_SESSION['message']);
	}
   
   ?>

   <?php $col=getAll("collection");
   if(mysqli_num_rows($col)  > 0){
     foreach($col as $item){
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
<div class="card mb-3">
  <a href="product.php?collection=<?=$item['colName'];?>">
  <div class="img">
  <img src="upload/<?=$item['colImage'];?>" alt="<?=$item['colName'];?>" class="card-img-top" alt="<?=$item['colName'];?>">
  </div>
  </a>
  <div class="card-body">
  <p class="card-text text-center">Fragrance</p>
    <h5 class="card-title text-center"><?=$item['colName'];?></h5>
    <p class="card-text text-center"><?=$item['colDescription'];?></p>
    <div class="dis">
   
    <input type="hidden" name="collectionID" value="<?=$item['collectionID'];?>">  
   <a href="product.php?collection=<?=$item['colName'];?>">
    <button name="product_btn" class="btn btn-outline-secondary btn-border-radius">Discover</button>
    </a>
    </div>
  </div>
</div>



<?php }}?>
<!-- footer -->
<div class="py-5">
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <h4 class="text-black">DIOR New York Bloomingdales</h4>
      <p>Dior Boutique</p>
      <div class="underline mb-2"></div>
      <a href="" class="text-black">Home</a><br>
      <a href="" class="text-black">Collection</a><br>
      <a href="" class="text-black">Cart</a><br>
      <a href="" class="text-black"></a>
    </div>
    <div class="col-md-3">
      <h4>Address</h4>
      <p>
      1000 Third Avenue NY New York, NY 10022
      </p>
      <a href="tel:+12127053522" class="text-black"><i class="fa fa-envelope">+12127053522</i></a>
      <a href="tel:+091281288218" class="text-black"><i class="fa fa-envelope">diro@gmail.com</i></a>
    </div>
    <div class="col-md-6">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24189.613258547262!2d-74.03816878795624!3d40.724583756287295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2598e90b6e667%3A0x9acacbb66786018f!2sDIOR%20New%20York%20Soho!5e0!3m2!1sen!2smm!4v1722013274669!5m2!1sen!2smm" class="w-100" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div>
 </div>
<div class="py-2">
  <div class="text-center">
    <p class="mb-0">All rights reserved. Copyright @ <a href="https://www.dior.com/en_us/beauty" target="_blank" >Dior</a>-<?=date('Y')?></p>
  </div>
</div>
<?php include('include/footer.php');?>