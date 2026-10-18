<!DOCTYPE html> 
<html> 
<head> 
	
	<meta content="initial-scale=1, maximum-scale=1, 
		user-scalable=0" name="viewport" /> 
	<meta name="viewport" content="width=device-width" /> 

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
	<!-- Datatable plugin CSS file -->
	<link rel="stylesheet" href= 
"https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" /> 

	<!-- jQuery library file -->
	<script type="text/javascript"
	src="https://code.jquery.com/jquery-3.5.1.js"> 
	</script> 

	<!-- Datatable plugin JS library file -->
	<script type="text/javascript" src= 
"https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> 
	</script> 
</head> 

<body>
    <form action="" class="form-group">
       Product Name: <input type="text" name="" id="" class="form-control">
       Product Type: <input type="text" name="" id="" class="form-control">
       Price: <input type="text" name="" id="" class="form-control">
        <input type="submit" value="ADD" class="btn btn-primary">
    </form> 
	<h2>Pagination using jQuery Datatables </h2> 

	<!--HTML table with student data-->
	<table id="tableID" class="display" style="width:100%"> 
		<thead> 
			<tr> 
				<th>StudentID</th> 
				<th>StudentName</th> 
				<th>Age</th> 
				<th>Gender</th> 
				<th>Marks Scored</th> 
			</tr> 
		</thead> 
		<tbody> 
			<tr> 
				<td>ST1</td> 
				<td>Prema</td> 
				<td>35</td> 
				<td>Female</td> 
				<td>320</td> 
			</tr> 
			<tr> 
				<td>ST2</td> 
				<td>Wincy</td> 
				<td>36</td> 
				<td>Female</td> 
				<td>170</td> 
			</tr> 
			<tr> 
				<td>ST3</td> 
				<td>Ashmita</td> 
				<td>41</td> 
				<td>Female</td> 
				<td>860</td> 
			</tr> 
			
		</tbody> 
	</table> 

	<script> 

		/* Initialization of datatable */ 
		$(document).ready(function() { 
			$('#tableID').DataTable({ }); 
		}); 
	</script> 
</body> 

</html>