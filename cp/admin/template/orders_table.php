<?php
if (!function_exists('e')) { http_response_code(404); exit; } // only usable when included by a page
/* Shared orders table for order.php and orderHistory.php. Expects $orders. */
?>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Customer</th>
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
          <td><?= e($item['name']) ?></td>
          <td><?= e($item['tracking_no']) ?></td>
          <td>$<?= money($item['o_totalAmount']) ?></td>
          <td><?= e(statusLabel($item['status'])) ?></td>
          <td><?= e($item['created_at']) ?></td>
          <td><a href="viewOrder.php?t=<?= e(urlencode($item['tracking_no'])) ?>" class="btn btn-dark">View Details</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$orders): ?>
        <tr><td colspan="7">No orders here yet</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
