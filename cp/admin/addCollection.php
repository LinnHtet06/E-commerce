<?php 
session_start();
include('template/header.php');
include('../functions/myfunction.php');
?>


<div class="main-panel">
  
        <div class="content-wrapper">
  
<div class="card">

                  <div class="card-body">
                    <h4 class="card-title">Add to Collection</h4>
                    <form class="form-sample" action="categoryCode.php" method="POST" enctype="multipart/form-data">
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="colName" class="form-control" placeholder="Enter name">
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                          
                        <div class="col-md-3">
                          <div class="form-group row">
                          <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="Lte" > Limited Edition</label>
                            </div>
                          </div>
                          </div>
                          
                        </div>
                        
                        
                        
                        
                        <div class="col-md-12">
                        <div class="form-group">
                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" name="colDescription"  rows="4"></textarea>
                      </div>
                        </div>
                      
                        <div class="col-md-6">
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="file-upload">Upload Image</label>
                            <div class="col-sm-9">
                            <input id="file-upload" class="form-control file-upload-info " type="file" name="image" accept="image/*">
                            </div>
                          </div>
                        </div>
                      </div>
                      <button type="submit" name="addCollection" class="btn btn-primary mr-2">Add</button>
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
        <th>Limited Edition</th>
        <th>collectionImage</th>
        <th>Men</th>
        <th>Women</th>
        <th>Edit</th>
        <th>DELETE</th> 
				
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
        <td><img src="../upload/<?=$item['colImage'];?>" alt="<?=$item['colImage'];?>" width='50px' height='50px' ></td> 
        <td><?=$item['limitedEdition'];?></td> 
        <td><?=$item['limitedEdition'];?></td> 
        <td>
          <a class="btn btn-primary" href="editCollection.php?id=<?=$item['collectionID'];?>">Edit</a>
    </td>
    <td>
          <form action="categoryCode.php" method="POST" >
            <input type="hidden" name="collectionID" value="<?=$item['collectionID'];?>">
          <button type="submit" name="deleteColBtn" value="<?=$item['collectionID'];?>" class="btn btn-danger">Delete</button>
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
  <?php include('template/footer.php'); ?>
    <script src="assets/js/dashboard.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    
    
  </body>
  </html>

 