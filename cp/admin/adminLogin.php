<?php
require_once __DIR__ . '/../functions/myfunction.php';
if (is_admin()) {
    redirect('index.php', 'You are already logged in');
}
$pageTitle = 'Admin Login';
$formTitle = 'Admin Login';
$renderForm = function () { ?>
  <form action="../functions/authCode.php" method="POST">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="mail" id="email" placeholder="Enter your email" class="form-control p_input" required autocomplete="email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="pass" id="password" placeholder="Enter your password" class="form-control p_input" required autocomplete="current-password">
    </div>
    <div class="text-center">
      <button type="submit" name="AdminLogin" class="btn btn-primary btn-block enter-btn">Login</button>
    </div>
    <p class="sign-up mt-3 mb-0"><a href="../index.php">&larr; Back to the shop</a></p>
  </form>
<?php };
include __DIR__ . '/template/auth_layout.php';
