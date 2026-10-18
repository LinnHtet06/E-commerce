
<?php
session_start();
include('include/header.php');
include('functions/userfunction.php');
if(isset($_SESSION['auth']))
{
	redirect('index.php',"You are already logIn");
	exit();
}	


			if(isset($_SESSION['message']))
			{
			?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Hey!</strong> <?=$_SESSION['message'];?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php
	unset($_SESSION['message']);
	}
	?> 
	<div class="py-5">
		<div class="container">
			<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<h1 class="registerTitle">Customer Register </h1>
					</div>
					<div class="card-body">
			<form class="contactForm" action="userfunction.php" method="POST">
			<div class="input-group mb-3">
			<span class="input-group-text" id="name">Name</span>
			<input type="text" class="form-control" name="name" id="name" required >
			</div>

			<div class="input-group mb-3">
			<span class="input-group-text" id="email"><i class="bi bi-envelope-at"></i>Email</span>
			<input type="email" class="form-control" name="mail" id="email" required >
			</div>

			<div class="input-group mb-3">
			<span class="input-group-text" id="phone"><i class="bi bi-phone"></i>Phone</span>
			<input type="text" class="form-control" name="phone" id="phone" required >
			</div>
			
			<div class="input-group mb-3">
			<span class="input-group-text" id="address">Address</span>
			<input type="text" class="form-control" name="address" id="address" required >
			</div>

			<div class="input-group mb-3">
			<span class="input-group-text" id="pass"><i class="bi bi-file-lock"></i>Password</span>
			<input type="password" class="form-control" name="pass" id="password" required >
			</div>

			<div class="input-group mb-3">
			<span class="input-group-text" id="password"><i class="bi bi-file-lock"></i>Confirm password</span>
			<input type="password" class="form-control" name="cpass" id="password" required >
			</div>

				<input type="submit" name="submit" value="Submit" class="btn btn-primary">
				
		</form>
			</div>
			</div>
			</div>
			</div>
			</div>
			
		
</div>
</div>
</body>

</html>