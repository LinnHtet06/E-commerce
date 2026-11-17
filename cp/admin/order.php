<?php
$pageTitle = 'Orders | DIOR Admin';
include __DIR__ . '/template/header.php';
$orders = getPendingOrders();
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title d-flex justify-content-between align-items-center">
          Orders awaiting action
          <a href="orderHistory.php" class="btn btn-info">Order history</a>
        </h4>
        <?php include __DIR__ . '/template/orders_table.php'; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
