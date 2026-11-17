<?php
$pageTitle = 'Dashboard | DIOR Admin';
include __DIR__ . '/template/header.php';
$stats = getDashboardStats();
$cards = [
    ['Revenue (excl. cancelled)', '$' . money($stats['revenue']), 'mdi-currency-usd', 'success'],
    ['Orders awaiting action', $stats['pending'], 'mdi-cart-outline', $stats['pending'] ? 'danger' : 'success'],
    ['Products', $stats['products'], 'mdi-flask-outline', 'success'],
    ['Customers', $stats['customers'], 'mdi-account-multiple', 'success'],
];
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <?php foreach ($cards as [$label, $value, $icon, $tone]): ?>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-9">
                  <h3 class="mb-0"><?= e($value) ?></h3>
                </div>
                <div class="col-3">
                  <div class="icon icon-box-<?= e($tone) ?>">
                    <span class="mdi <?= e($icon) ?> icon-item"></span>
                  </div>
                </div>
              </div>
              <h6 class="text-muted font-weight-normal"><?= e($label) ?></h6>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="row">
      <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Recent orders</h4>
            <div class="table-responsive">
              <table class="table">
                <thead><tr><th>Tracking</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                  <?php foreach ($stats['recent'] as $order): ?>
                    <tr>
                      <td><?= e($order['tracking_no']) ?></td>
                      <td><?= e($order['name']) ?></td>
                      <td>$<?= money($order['o_totalAmount']) ?></td>
                      <td><?= e(statusLabel($order['status'])) ?></td>
                      <td><a class="btn btn-sm btn-outline-light" href="viewOrder.php?t=<?= e(urlencode($order['tracking_no'])) ?>">View</a></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (!$stats['recent']): ?>
                    <tr><td colspan="5">No orders yet</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Low stock (5 or fewer)</h4>
            <ul class="list-unstyled mb-0">
              <?php foreach ($stats['lowStock'] as $product): ?>
                <li class="d-flex justify-content-between border-bottom py-2">
                  <a href="editProduct.php?id=<?= (int) $product['p_id'] ?>"><?= e($product['p_name']) ?></a>
                  <span class="<?= $product['p_stock'] <= 0 ? 'text-danger' : 'text-warning' ?>">
                    <?= $product['p_stock'] <= 0 ? 'Out of stock' : (int) $product['p_stock'] . ' left' ?>
                  </span>
                </li>
              <?php endforeach; ?>
              <?php if (!$stats['lowStock']): ?>
                <li>All products are well stocked.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
