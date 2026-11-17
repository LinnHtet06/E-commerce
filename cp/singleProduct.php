<?php
require_once __DIR__ . '/functions/userfunction.php';

// Products are linked by id; ?product=<name> still works for old links.
$product = null;
if ($id = positive_int($_GET['id'] ?? null)) {
    $product = getProductById($id);
} elseif (isset($_GET['product'])) {
    $product = getProductByName((string) $_GET['product']);
}
$pageTitle = $product ? $product['p_name'] . ' | Dior' : 'Product not found | Dior';
include __DIR__ . '/include/header.php';
?>
<?php if (!$product): ?>
  <div class="container py-5 text-center">
    <h4>Product not available</h4>
    <a href="index.php" class="btn btn-dark mt-3">Back to home</a>
  </div>
<?php else: ?>
  <?php $inStock = $product['p_stock'] > 0; ?>
  <div class="py-3">
    <div class="container">
      <h6 class="text-black">
        <a class="text-black" href="index.php">Home</a> /
        <a class="text-black" href="product.php?collection=<?= e(urlencode($product['colName'])) ?>"><?= e($product['colName']) ?></a> /
        <?= e($product['p_name']) ?>
      </h6>
    </div>
  </div>

  <div class="container mt-3 mb-5 product_data">
    <div class="row">
      <div class="col-md-4">
        <img src="upload/<?= e($product['p_image']) ?>" alt="<?= e($product['p_name']) ?>" class="w-100">
      </div>
      <div class="col-md-8">
        <div class="row mt-3">
          <div class="col-10">
            <h4><?= e($product['p_name']) ?></h4>
          </div>
          <div class="col-2 text-end">
            <button class="btn wish" type="button" value="<?= (int) $product['p_id'] ?>" title="Add to wishlist"><i class="bi bi-heart"></i></button>
          </div>
        </div>
        <hr>
        <p><?= e($product['p_note']) ?></p>

        <?php if ($product['p_size']): ?>
          <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
          <label class="btn btn-secondary mb-3" for="option1"><?= e($product['p_size']) ?></label>
        <?php endif; ?>

        <h6>Description:</h6>
        <p><?= nl2br(e($product['p_description'])) ?></p>
        <h6>Ingredients</h6>
        <p><?= e($product['p_ingredients']) ?></p>

        <?php if ($inStock): ?>
          <p class="text-success">In stock<?= $product['p_stock'] <= 5 ? ' (only ' . (int) $product['p_stock'] . ' left)' : '' ?></p>
          <div class="input-group mb-3" style="width:140px">
            <button class="input-group-text decrement-btn" type="button" aria-label="Decrease quantity">-</button>
            <input type="text" class="form-control text-center bg-white qty" value="1" data-max="<?= (int) $product['p_stock'] ?>" readonly>
            <button class="input-group-text increment-btn" type="button" aria-label="Increase quantity">+</button>
          </div>
          <button class="btn btn-dark add-to-bag-btn" type="button" value="<?= (int) $product['p_id'] ?>">
            <span>ADD</span>
            <span class="priceBtn">Buy $<?= money($product['p_price']) ?></span>
          </button>
        <?php else: ?>
          <p class="text-danger fw-bold">Out of stock</p>
          <button class="btn btn-secondary" type="button" disabled>$<?= money($product['p_price']) ?> · Out of stock</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php include __DIR__ . '/include/footer.php'; ?>
