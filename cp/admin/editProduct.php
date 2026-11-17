<?php
$pageTitle = 'Edit product | DIOR Admin';
include __DIR__ . '/template/header.php';
$product = ($id = positive_int($_GET['id'] ?? null)) ? getProduct($id) : null;
$collections = getAllCollections();
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <?php if (!$product): ?>
          <h4 class="card-title">Product not found</h4>
          <a href="products.php" class="btn btn-secondary">Back to products</a>
        <?php else: ?>
          <h4 class="card-title">Edit product: <?= e($product['p_name']) ?></h4>
          <?php include __DIR__ . '/template/product_form.php'; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
