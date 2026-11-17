<?php
require_once __DIR__ . '/functions/userfunction.php';
$collections = getCollections();
include __DIR__ . '/include/header.php';
?>
<div class="container py-4" id="collections">
  <?php if (!$collections): ?>
    <p class="text-center py-5">No collections yet. Add some from the admin panel.</p>
  <?php endif; ?>

  <?php foreach ($collections as $item): ?>
    <?php $collectionUrl = 'product.php?collection=' . urlencode($item['colName']); ?>
    <div class="card mb-3">
      <a href="<?= e($collectionUrl) ?>">
        <div class="img">
          <img src="upload/<?= e($item['colImage']) ?>" alt="<?= e($item['colName']) ?>" class="card-img-top">
        </div>
      </a>
      <div class="card-body">
        <p class="card-text text-center">Fragrance<?= $item['limitedEdition'] ? ' · Limited Edition' : '' ?></p>
        <h5 class="card-title text-center"><?= e($item['colName']) ?></h5>
        <p class="card-text text-center"><?= e($item['colDescription']) ?></p>
        <div class="dis">
          <a href="<?= e($collectionUrl) ?>" class="btn btn-outline-secondary btn-border-radius">Discover</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- footer -->
<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h4 class="text-black">DIOR New York Bloomingdales</h4>
        <p>Dior Boutique</p>
        <div class="underline mb-2"></div>
        <a href="index.php" class="text-black">Home</a><br>
        <a href="#collections" class="text-black">Collections</a><br>
        <?php if (is_customer()): ?>
          <a href="#" class="text-black" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">Cart</a><br>
        <?php else: ?>
          <a href="loginUi.php" class="text-black">Cart</a><br>
        <?php endif; ?>
        <a href="admin/adminLogin.php" class="text-black">Admin login</a>
      </div>
      <div class="col-md-3">
        <h4>Address</h4>
        <p>1000 Third Avenue NY New York, NY 10022</p>
        <a href="tel:+12127053522" class="text-black"><i class="bi bi-telephone"></i> +1 212 705 3522</a><br>
        <a href="mailto:diro@gmail.com" class="text-black"><i class="bi bi-envelope"></i> diro@gmail.com</a>
      </div>
      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24189.613258547262!2d-74.03816878795624!3d40.724583756287295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2598e90b6e667%3A0x9acacbb66786018f!2sDIOR%20New%20York%20Soho!5e0!3m2!1sen!2smm!4v1722013274669!5m2!1sen!2smm" class="w-100" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Boutique location"></iframe>
      </div>
    </div>
  </div>
</div>
<div class="py-2">
  <div class="text-center">
    <p class="mb-0">Student portfolio project, not affiliated with <a href="https://www.dior.com/en_us/beauty" target="_blank" rel="noopener">Dior</a> · <?= date('Y') ?></p>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
