<?php
require_once __DIR__ . '/functions/userfunction.php';
require_customer();
$items = getWishItems();
$pageTitle = 'Wishlist | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-3">
  <div class="container">
    <h1 class="text-center mt-2">Wishlist</h1>
    <p id="wishEmpty" class="text-center py-4 <?= $items ? 'd-none' : '' ?>">Your wishlist is empty.</p>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2" id="wish">
      <?php foreach ($items as $wishItem): ?>
        <div class="col wishlist-item">
          <div class="card">
            <a href="singleProduct.php?id=<?= (int) $wishItem['p_id'] ?>">
              <img src="upload/<?= e($wishItem['p_image']) ?>" alt="<?= e($wishItem['p_name']) ?>" class="w-100">
            </a>
            <div class="card-body">
              <h5 class="card-title"><?= e($wishItem['p_name']) ?></h5>
              <h5 class="card-title">$<?= money($wishItem['p_price']) ?></h5>
              <a href="singleProduct.php?id=<?= (int) $wishItem['p_id'] ?>" class="btn btn-dark">View</a>
              <button class="btn btn-danger removeWishList" type="button" value="<?= (int) $wishItem['wID'] ?>">Remove</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
