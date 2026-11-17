<?php
require_once __DIR__ . '/../functions/myfunction.php';

// Only a logged-in admin can add another admin. The one exception is a brand-new
// install with no admins at all, so the very first admin can be created.
if (!is_admin() && (int) db_value('SELECT COUNT(*) FROM admin') > 0) {
    redirect('adminLogin.php', 'Please log in as an admin to add another admin');
}

$pageTitle = 'Add Admin';
$formTitle = is_admin() ? 'Add a new admin' : 'Create the first admin';
$renderForm = function () { ?>
  <form action="../functions/authCode.php" method="POST">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control p_input" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="mail" id="email" class="form-control p_input" required>
    </div>
    <div class="form-group">
      <label for="gender">Gender</label>
      <select class="form-control" name="gender" id="gender">
        <option>Female</option>
        <option>Male</option>
        <option>Other</option>
      </select>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="pass" id="password" minlength="6" class="form-control p_input" required autocomplete="new-password">
    </div>
    <div class="form-group">
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" name="cpass" id="confirmPassword" minlength="6" class="form-control" required autocomplete="new-password">
    </div>
    <div class="text-center">
      <button type="submit" name="Adminsubmit" class="btn btn-primary btn-block enter-btn">Create admin</button>
    </div>
    <p class="sign-up text-center mt-3 mb-0"><a href="<?= is_admin() ? 'index.php' : 'adminLogin.php' ?>">Cancel</a></p>
  </form>
<?php };
include __DIR__ . '/template/auth_layout.php';
