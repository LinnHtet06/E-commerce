<?php
session_start();
 include('include/header.php');
 include('functions/userfunction.php');
 if(isset($_GET['collection']))
 {
 $colName=$_GET['collection'];
 $colData=getcolName("collection",$colName);
 $col=mysqli_fetch_array($colData);
 if($col)
 {
 $colID=$col['collectionID'];
 ?>
<div class="py-3">
    <div class="container">
        <h6 class="text-black">
            <a class="text-black" href="index.php">
            Home/
            </a>
            <a class="text-black" href="product.php?collection=<?=$col['colName'];?>">
            
                <?=$col['colName'];?> Collection
            </a>
        </h6>
    </div>
</div>

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
    <h1><?=$col['colName'];?></h1><hr>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php 
    
                $product=getProductByCollection($colID);
                if(mysqli_num_rows($product)  > 0){
                foreach($product as $data){
                
                ?>
            <div class="col">
                <div class="card h-100">
                    <a href="singleProduct.php?product=<?=$data['p_name'];?>">
                    <div class="img-container">
                <img src="upload/<?=$data['p_image'];?>" class="card-img-top" alt="upload/<?=$data['p_name'];?>">
                </div>
                </a>
                <div class="card-body">
                    <h5 class="card-title text-center"><?=$data['p_name'];?></h5>
                    <p class="card-text text-center"><?=$data['p_note'];?></p>
                    <p class="card-text text-center">$<?=$data['p_price'];?></p>
                    <div class=" btn-border-radius dis"><a class="btn btn-outline-secondary btn-border-radius"href="singleProduct.php?product=<?=$data['p_name'];?>">Buy</a></div>
                </div>
                </div>
            </div>
            <?php }
            }
            else{
                echo "no data found";
            }
            ?>

         </div>
         </div>
 </div>
        



<?php
 }
 else{
    echo "Something Went Wrong";
}
} 
else{
    echo "Something Went Wrong";
}
include('include/footer.php');
?>