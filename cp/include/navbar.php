<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">DIOR</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto align-items-lg-center">
        <a class="nav-link" href="index.php">Home</a>
        <?php foreach (getCollections() as $navCollection): ?>
          <a class="nav-link" href="product.php?collection=<?= e(urlencode($navCollection['colName'])) ?>"><?= e($navCollection['colName']) ?></a>
        <?php endforeach; ?>

        <a class="nav-link" href="wishUi.php" title="Wishlist"><i class="bi bi-heart"></i><span class="d-lg-none"> Wishlist</span></a>

        <?php if (is_customer()): ?>
          <button class="btn btn-dark text-start" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" title="Cart">
            <i class="bi bi-bag"></i><span class="d-lg-none"> Cart</span>
          </button>
          <span class="nav-link"><i class="bi bi-person"></i> <?= e($_SESSION['auth_user']['c_name']) ?></span>
          <a class="nav-link" href="myOrder.php">My Orders</a>
          <a class="nav-link" href="logOut.php">Log out</a>
        <?php else: ?>
          <a class="nav-link" href="register.php">Register</a>
          <a class="nav-link" href="loginUi.php">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
