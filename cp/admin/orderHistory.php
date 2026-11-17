<?php
$pageTitle = 'Order history | DIOR Admin';
include __DIR__ . '/template/header.php';
$orders = getOrderHistory();
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title d-flex justify-content-between align-items-center">
          Order history (completed and cancelled)
          <a href="order.php" class="btn btn-warning">Back</a>
        </h4>
        <?php include __DIR__ . '/template/orders_table.php'; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
