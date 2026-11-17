<?php
require_once __DIR__ . '/functions/userfunction.php';
if (is_customer()) {
    redirect('index.php', 'You are already logged in');
}
$pageTitle = 'Register | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h1 class="registerTitle">Customer Register</h1>
          </div>
          <div class="card-body">
            <form class="contactForm" action="functions/authCode.php" method="POST">
              <div class="input-group mb-3">
                <label class="input-group-text" for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required autocomplete="name">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="email"><i class="bi bi-envelope-at me-1"></i>Email</label>
                <input type="email" class="form-control" name="mail" id="email" required autocomplete="email">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="phone"><i class="bi bi-phone me-1"></i>Phone</label>
                <input type="tel" class="form-control" name="phone" id="phone" required autocomplete="tel">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" required autocomplete="street-address">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="password"><i class="bi bi-file-lock me-1"></i>Password</label>
                <input type="password" class="form-control" name="pass" id="password" minlength="6" required autocomplete="new-password">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="confirmPassword"><i class="bi bi-file-lock me-1"></i>Confirm password</label>
                <input type="password" class="form-control" name="cpass" id="confirmPassword" minlength="6" required autocomplete="new-password">
              </div>
              <input type="submit" name="submit" value="Register" class="btn btn-primary">
              <p class="mt-3 mb-0">Already have an account? <a href="loginUi.php">Log in</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
