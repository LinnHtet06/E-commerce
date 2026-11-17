<?php
require_once __DIR__ . '/functions/userfunction.php';
if (is_customer()) {
    redirect('index.php', 'You are already logged in');
}
$pageTitle = 'Login | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h1 class="registerTitle">Customer Login</h1>
          </div>
          <div class="card-body">
            <form method="POST" action="functions/authCode.php">
              <div class="input-group mb-3">
                <label class="input-group-text" for="email"><i class="bi bi-envelope-at me-1"></i>Email</label>
                <input type="email" class="form-control" name="mail" id="email" required autocomplete="email">
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="password"><i class="bi bi-file-lock me-1"></i>Password</label>
                <input type="password" class="form-control" name="pass" id="password" required autocomplete="current-password">
              </div>
              <button type="submit" class="btn btn-primary" name="logIn" id="logIn">Log In</button>
              <p class="mt-3 mb-0">New here? <a href="register.php">Create an account</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
