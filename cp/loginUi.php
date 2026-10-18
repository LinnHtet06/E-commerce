<?php
session_start();
include('functions/userfunction.php');
if(isset($_SESSION['auth']))
{
	redirect("index.php","You are already logIn");
	exit();
}
include("include/header.php");

?> 
<div class="py-5">
	<div class="container">

	<?php
	if(isset($_SESSION['message']))
	{?>

	
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong>Holy!</strong> <?= $_SESSION['message'];?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php
  unset($_SESSION['message']);
	}
	?>
	
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<h1 class="registerTitle">Customer Login </h1>
					</div>
					<div class="card-body">
					<form method="POST" action="functions/authCode.php">
			<div class="input-group mb-3">
			<span class="input-group-text" id="email"><i class="bi bi-envelope-at"></i>Email</span>
			<input type="email" class="form-control" name="mail" id="email" required >
			</div>
	
			<div class="input-group mb-3">
			<span class="input-group-text" id="password"><i class="bi bi-file-lock"></i>Password</span>
			<input type="password" class="form-control" name="pass" id="password" required >
			</div>
	
				
			<button type="submit" class="btn btn-primary" name="logIn" id="logIn">Log In</button>
	
				<!-- <input class="btn" type="submit" name="logIn" id="logIn" value="LogIn"> -->
					</form>
					</div>
				</div>
			</div>
		</div>
	
	
		
	</div>
	</div>
</body>
</html>	
<?php include('include/footer.php')?>