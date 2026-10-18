
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Member register</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
	<section class="container">
		
		<form class="contactForm" action="register.php" method="POST">
			<h1 class="registerTitle">Admin SingUp Form</h1>
			<div class="contactName">
			<label>Admin First Name</label>
			<input type="text" name="firstName" value="" required>
			</div>

			<div class="contactName">
			<label>Admin Last Name</label>
			<input type="text" name="lastName" value="" required>
			</div>

			<div class="contactName">
			<label>Admin Email</label>
			<input type="email" name="mail" value="" required>
			</div>

      <div class="contactName">
			<label>Admin Phone</label>
			<input type="number" name="phone" value="" required>
			</div>
			
      <div class="contactName">
			<label>Admin Address</label>
			<input type="text" name="address" value="" required>
			</div>

			<div class="contactName">
			<label>Admin Password</label>
			<input type="password" name="pass" value="" required>
			</div>

				<input type="submit" name="submit" value="Submit" class="btn">
				
		</form>
	</section>
</body>

</html>