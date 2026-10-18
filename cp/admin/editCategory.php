<?php 
session_start();
include('template/header.php');
include('../functions/myfunction.php');
?>


<div class="main-panel">
  
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if(isset($_GET['id']))
                    {
                        $id=$_GET['id'];
                        $category=getId("product",$id);

                        if(mysqli_num_rows($category)>0)
                        {
                            $data=mysqli_fetch_array($category);
                            ?>
                        <div class="card">
                                          <div class="card-body">
                                            <h4 class="card-title">Edit Category</h4>
                                            <form class="form-sample" action="categoryCode.php" method="POST" enctype="multipart/form-data">
                                              
                                              <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="categoryID" value="<?=$data["p_id"]?>">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="name" value="<?=$data["p_name"]?>" class="form-control" placeholder="Enter name">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Price</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="price" value="<?=$data["p_price"]?>" class="form-control" placeholder="Enter price">
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
                                                      <input class="form-control" name="size" value="<?=$data["p_size"]?>" placeholder="Enter bottle size">
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Stock Quantity</label>
                                                    <div class="col-sm-9">
                                                      <input class="form-control" name="stockqty" value="<?=$data["p_stock"]?>" placeholder="Enter quantity">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Fragrance Note</label>
                                                    <div class="col-sm-9">
                                                      <input class="form-control" name="note" value="<?=$data["p_note"]?>" placeholder="Enter note">
                                                    </div>
                                                  </div>
                                                </div>
                                                </div>
                                                
                                              
                                              <div class="row">
                                                <div class="col-md-6">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Production Date</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="productionDate" value="<?=$data["p_productionDate"]?>" class="form-control">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Expire Date</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="expirationDate" value="<?=$data["p_expirationDate"]?>" class="form-control">
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="exampleInputCity1">Ingredients</label>
                                                <input type="text" name="ingredients" value="<?=$data["p_ingredients"]?>" class="form-control"  placeholder="Enter ingredients">
                                              </div>
                                              <div class="form-group">
                                                <label for="exampleTextarea1">Description</label>
                                                <textarea class="form-control" name="description"  rows="4"><?=$data["p_description"]?></textarea>
                                              </div>
                        
                                              
                                              
                                              <div class="row">
                                                <div class="col-md-6">
                                                  <div class="form-group row">
                                                  <label class="col-sm-3 col-form-label" for="file-upload">Upload Image</label>
                                                    <div class="col-sm-9">
                                                    <input id="file-upload" class="form-control file-upload-info " type="file" name="image" accept="image/*">
                                                    <label class="col-sm-3 col-form-label" for="">Current Image</label>
                                                    <input type="hidden" name="oldImage" value="<?=$data["p_image"]?>">
                                                    <img src="../upload/<?=$data["p_image"]?>" height="50px" width="50px" alt="<?=$data["p_name"]?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                
                                                
                                              </div>
                                              <button type="submit" name="updateCategory" class="btn btn-primary mr-2">Update</button>
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
                                        <th>Description</th> 
                                        <th>Image</th> 
                                <th>Stock</th> 
                                        <th>Note</th>
                                 
                                <th>ProductionDate</th> 
                                        <th>ExpirationDate</th> 
                                <th>Size</th> 
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
                                        <td><?=$item['p_description'];?></td> 
                                        <td><img src="../upload/<?=$item['p_image'];?>" alt="<?=$item['p_image'];?> width="70px" height='70px'></td> 
                                <td><?=$item['p_stock'];?></td> 
                                <td><?=$item['p_note'];?></td> 
                                 
                                <td><?=$item['p_productionDate'];?></td> 
                                <td><?=$item['p_expirationDate'];?></td> 
                                <td><?=$item['p_size'];?></td> 
                                <td><?=$item['p_ingredients'];?></td> 
                                <td><?=$item['collectionID'];?></td>
                                <td>
                                  <a class="btn btn-primary" href="editCategory.php?id=<?=$item['p_id'];?>">Edit ID<?=$item['p_id'];?></a>
                            </td>
                            <td>
                                <form action="" method="POST">
                                  <input type="hidden" name="categoryID" <?=$item['p_id'];?>>
                                <button class="btn btn-danger">Delete</button>
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
                        <?php
                    }
                            else{
                                echo "Category not found";
                            }
                        
                        ?>

                        <?php

                    }
                    else{
                        echo "id missing from URL";
                    }
                    ?>
                </div>
            </div>
            </div>
            <?php include('template/footer.php');?> 
                </body>
</html>

               