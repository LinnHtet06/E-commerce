<?php 
session_start();
include('template/header.php');
include('../functions/myfunction.php');
?>


<div class="main-panel">
  
        <div class="content-wrapper">
<div class="card">

 
                  <div class="card-body">
                    <h4 class="card-title">Add to Category</h4>
                    <form class="form-sample" action="categoryCode.php" method="POST" enctype="multipart/form-data">
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                              <input type="text" name="price" class="form-control" placeholder="Enter price" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select Category</label>
                            <div class="col-sm-9">
                              <select name="collectionID" class="form-control">
                                <option selected>Select Category</option>
                                <?php 
                              $collection=getAll("collection");
                              if(mysqli_num_rows($collection)>0)
                              {
                                foreach($collection as $col)
                                {
                                  ?>
                                  <option value="<?= $col['collectionID']?>"><?= $col['colName']?></option>
                                  <?php
                                }
                              }
                              else
                              {
                                echo "No collection available";
                              }
                              
                              ?>
                                
                              </select>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">size</label>
                            <div class="col-sm-9">
                              <input class="form-control" name="size" placeholder="Enter bottle size" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stock Quantity</label>
                            <div class="col-sm-9">
                              <input class="form-control" name="stockqty" placeholder="Enter quantity" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Fragrance Note</label>
                            <div class="col-sm-9">
                              <input class="form-control" name="note" placeholder="Enter note" required>
                            </div>
                          </div>
                        </div>
                        </div>
                        
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Production Date</label>
                            <div class="col-sm-9">
                              <input type="text" name="productionDate" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Expire Date</label>
                            <div class="col-sm-9">
                              <input type="text" name="expirationDate" class="form-control" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Ingredients</label>
                        <input type="text" name="ingredients" class="form-control"  placeholder="Enter ingredients" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" name="description"  rows="4"></textarea>
                      </div>

                      
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="file-upload">Upload Image</label>
                            <div class="col-sm-9">
                            <input id="file-upload" class="form-control file-upload-info " type="file" name="image" accept="image/*">
                            </div>
                          </div>
                        </div>
                        
                        
                      </div>
                      <button type="submit" name="addCategory" class="btn btn-primary mr-2">Add</button>
                    </form>
                  </div>
                </div>

                
                  <div class="row">
                  <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                      <div class="cardbody">
                          <h4 class="card-title mt-5">Categories</h4>
                          <div class="table-responsive">
                          <table id="tableID" class="uk-table uk-table-hover uk-table-striped" style="width:100%;color:cyan">
		<thead> 
			<tr> 
				<th>ID</th> 
				<th>Name</th> 
				<th>Price</th> 
				
				<th>Image</th> 
        <th>Stock</th> 
				<th>Note</th>
        <th>Category</th> 
        <th>ProductionDate</th> 
				<th>ExpirationDate</th> 
        <th>Size</th> 
        <th>Description</th> 
				<th>Ingredients</th>
        <th>CollectionID</th>
        <th>Edit</th>
        <th>Delete</th>
			</tr> 
		</thead> 
    <tbody> 
    <?php
   $category=getAll("product");
   if(mysqli_num_rows($category)  > 0){
    foreach($category as $item){
      ?>
			<tr> 
				<td><?=$item['p_id'];?></td> 
				<td><?=$item['p_name'];?></td> 
				<td><?=$item['p_price'];?></td> 
				 
				<td><img src="../upload/<?=$item['p_image'];?>" alt="<?=$item['p_image'];?>" width='70px' height='70px' ></td> 
        <td><?=$item['p_stock'];?></td> 
        <td><?=$item['p_note'];?></td> 
        <td><?=$item['p_category'];?></td> 
        <td><?=$item['p_productionDate'];?></td> 
        <td><?=$item['p_expirationDate'];?></td> 
        <td><?=$item['p_size'];?></td> 
        <td><?=$item['p_description'];?></td>
        <td><?=$item['p_ingredients'];?></td> 
        <td><?=$item['collectionID'];?></td> 
        <td>
          <a class="btn btn-primary" href="editCategory.php?id=<?=$item['p_id'];?>">Edit</a>
    </td>
    <td>
          <form action="categoryCode.php" method="POST" >
            <input type="hidden" name="p_id" value="<?=$item['p_id'];?>">
          <button type="submit" name="deleteBtn" value="<?=$item['p_id'];?>" class="btn btn-danger delete_product_btn">Delete</button>
          
          </form>
      </td>
			</tr> 
      <?php
    }
    
   }
   else{
    echo "NO Data found";
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
 </div>  
          </body>
          <?php include('template/footer.php');?> 
  
</html>

               