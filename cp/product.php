<?php
require_once __DIR__ . '/functions/userfunction.php';
$col = isset($_GET['collection']) ? getCollectionByName((string) $_GET['collection']) : null;
$products = $col ? getProductsByCollection((int) $col['collectionID']) : [];
$pageTitle = $col ? $col['colName'] . ' | Dior' : 'Collection not found | Dior';
include __DIR__ . '/include/header.php';
?>
<?php if (!$col): ?>
  <div class="container py-5 text-center">
    <h4>Collection not found</h4>
    <a href="index.php" class="btn btn-dark mt-3">Back to home</a>
  </div>
<?php else: ?>
  <div class="py-3">
    <div class="container">
      <h6 class="text-black">
        <a class="text-black" href="index.php">Home</a> /
        <?= e($col['colName']) ?> Collection
      </h6>
    </div>
  </div>

  <div class="py-3">
    <div class="container">
      <h1><?= e($col['colName']) ?></h1>
      <hr>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!$products): ?>
          <p>No products in this collection yet.</p>
        <?php endif; ?>

        <?php foreach ($products as $data): ?>
          <?php $productUrl = 'singleProduct.php?id=' . (int) $data['p_id']; ?>
          <div class="col">
            <div class="card h-100">
              <a href="<?= e($productUrl) ?>">
                <div class="img-container">
                  <img src="upload/<?= e($data['p_image']) ?>" class="card-img-top" alt="<?= e($data['p_name']) ?>">
                </div>
              </a>
              <div class="card-body">
                <h5 class="card-title text-center"><?= e($data['p_name']) ?></h5>
                <p class="card-text text-center"><?= e($data['p_note']) ?></p>
                <p class="card-text text-center">$<?= money($data['p_price']) ?></p>
                <?php if ($data['p_stock'] <= 0): ?>
                  <p class="text-center text-danger mb-2">Out of stock</p>
                <?php endif; ?>
                <div class="btn-border-radius dis">
                  <a class="btn btn-outline-secondary btn-border-radius" href="<?= e($productUrl) ?>">
                    <?= $data['p_stock'] > 0 ? 'Buy' : 'View' ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php include __DIR__ . '/include/footer.php'; ?>
