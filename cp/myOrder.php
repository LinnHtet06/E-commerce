<?php
require_once __DIR__ . '/functions/userfunction.php';
require_customer();
$orders = getMyOrders();
$pageTitle = 'My Orders | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-3">
  <div class="container">
    <h6 class="text-black">
      <a class="text-black" href="index.php">Home</a> / My Orders
    </h6>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tracking Number</th>
            <th>Price</th>
            <th>Status</th>
            <th>Date</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $item): ?>
            <tr>
              <td><?= (int) $item['o_id'] ?></td>
              <td><?= e($item['tracking_no']) ?></td>
              <td>$<?= money($item['o_totalAmount']) ?></td>
              <td><?= e(statusLabel($item['status'])) ?></td>
              <td><?= e($item['created_at']) ?></td>
              <td>
                <a href="viewOrder.php?t=<?= e(urlencode($item['tracking_no'])) ?>" class="btn btn-dark">View Details</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$orders): ?>
            <tr><td colspan="6">No orders yet</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
