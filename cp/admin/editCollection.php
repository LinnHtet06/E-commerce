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
                        $col=getColId("collection",$id);

                        if(mysqli_num_rows($col)>0)
                        {
                            $data=mysqli_fetch_array($col);
                            ?>
                       
            
<div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit Collection</h4>
                    <form class="form-sample" action="categoryCode.php" method="POST" enctype="multipart/form-data">
                      
                      <div class="row">
                        <div class="col-md-6">
                        <input type="hidden" name="colID" value="<?=$data["collectionID"]?>">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="colName" value="<?= $data['colName']?>" class="form-control" placeholder="Enter name">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                          <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="Lte" id="optionsRadios1" value="<?= $data['limitedEdition']?>"> Limited Edition <i class="input-helper"></i></label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" name="colDescription"  rows="4"><?= $data['colDescription']?></textarea>
                      </div>
                        </div>

                        
                        <div class="col-md-6">
                                                  <div class="form-group row">
                                                  <label class="col-sm-3 col-form-label" for="file-upload">Upload Image</label>
                                                    <div class="col-sm-9">
                                                    <input id="file-upload" class="form-control file-upload-info " type="file" name="image" accept="image/*">
                                                    <label class="col-sm-3 col-form-label" for="">Current Image</label>
                                                    <input type="hidden" name="oldImage" value="<?=$data["colImage"]?>">
                                                    <img src="../upload/<?=$data["colImage"]?>" height="50px" width="50px" alt="<?=$data["colName"]?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                
                      </div>
                      <button type="submit" name="editCollection" class="btn btn-primary mr-2">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
                
              
                <table id="tableID" class="uk-table uk-table-hover uk-table-striped" style="width:100%;color:cyan"> 
		<thead> 
			<tr style="color:white"> 
				<th>CollectionID</th> 
				<th>CollectionName</th> 
				<th>Description</th>
        <th>Trending</th> 
        <th>colImage</th>
        <th>Edit</th> 
        <th>Delete</th> 
				
			</tr> 
		</thead> 
		<tbody> 
        <?php
   $col=getAllCol("collection");
   if(mysqli_num_rows($col)  > 0){
    foreach($col as $item){
      ?>
     
			<tr> 
				<td><?=$item['collectionID'];?></td> 
				<td><?=$item['colName'];?></td> 
				<td><?=$item['colDescription'];?></td> 
        <td><?=$item['limitedEdition'];?></td> 
				<td><img src="../upload/<?=$item['colImage'];?>" alt="<?=$item['colImage'];?>" width="70px" height='80px'></td> 
        <td>
          <a class="btn btn-primary" href="editCollection.php?id=<?=$item['collectionID'];?>">Edit</a>
    </td>
    <td>
          <form action="categoryCode.php" method="POST" >
            <input type="hidden" name="collectionID" value="<?=$item['collectionID'];?>">
          <button type="submit" name="deleteColBtn" class="btn btn-danger">Delete</button>
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
                    <?php include('template/footer.php');?> 
                    <script src="assets/js/dashboard.js"></script>
                    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
                </body>
</html>
    
   

 