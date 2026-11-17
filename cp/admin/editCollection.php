<?php
$pageTitle = 'Edit collection | DIOR Admin';
include __DIR__ . '/template/header.php';
$collection = ($id = positive_int($_GET['id'] ?? null)) ? getCollection($id) : null;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <?php if (!$collection): ?>
          <h4 class="card-title">Collection not found</h4>
          <a href="collections.php" class="btn btn-secondary">Back to collections</a>
        <?php else: ?>
          <h4 class="card-title">Edit collection: <?= e($collection['colName']) ?></h4>
          <?php include __DIR__ . '/template/collection_form.php'; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
