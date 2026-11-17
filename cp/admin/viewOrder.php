<?php
$pageTitle = 'View order | DIOR Admin';
include __DIR__ . '/template/header.php';
$data = isset($_GET['t']) ? getOrderByTracking((string) $_GET['t']) : null;
$lines = $data ? getOrderLines((int) $data['o_id']) : [];
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <?php if (!$data): ?>
        <div class="card-body">
          <h4 class="card-title">Order not found</h4>
          <a href="order.php" class="btn btn-warning">Back to orders</a>
        </div>
      <?php else: ?>
        <div class="card-header d-flex justify-content-between align-items-center">
          <span class="fs-3 fw-bold">Order <?= e($data['tracking_no']) ?></span>
          <a href="order.php" class="btn btn-warning">Back</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h4>Delivery Details</h4><hr>
              <?php
              $fields = [
                  'Name' => $data['name'],
                  'Email' => $data['email'],
                  'Phone' => $data['phone'],
                  'Tracking Number' => $data['tracking_no'],
                  'Address' => $data['address'],
                  'Postal Code' => $data['pincode'] ?: '-',
                  'Ordered at' => $data['created_at'],
              ];
              foreach ($fields as $label => $value): ?>
                <div class="mb-2">
                  <label class="font-weight-bold mb-0"><?= e($label) ?></label>
                  <div class="border p-1"><?= e($value) ?></div>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <h4>Order Details</h4><hr>
              <table class="table">
                <thead><tr><th>Product</th><th>Price</th><th>Quantity</th></tr></thead>
                <tbody>
                  <?php foreach ($lines as $item): ?>
                    <tr>
                      <td class="align-middle">
                        <?php if ($item['p_image']): ?>
                          <img src="../upload/<?= e($item['p_image']) ?>" alt="<?= e($item['oi_name']) ?>" width="50" height="50">
                        <?php endif; ?>
                        <?= e($item['oi_name']) ?>
                      </td>
                      <td class="align-middle">$<?= money($item['oi_price']) ?></td>
                      <td class="align-middle"><?= (int) $item['oi_quantity'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <hr>
              <h5>Total Price: <span class="float-right font-weight-bold">$<?= money($data['o_totalAmount']) ?></span></h5>
              <div class="mb-3"><span class="font-weight-bold">Payment Mode:</span> <?= e($data['payment_mode']) ?></div>

              <form action="adminCode.php" method="POST">
                <input type="hidden" name="trackingNumber" value="<?= e($data['tracking_no']) ?>">
                <label for="orderStatus" class="font-weight-bold">Status</label>
                <select name="orderStatus" id="orderStatus" class="form-control">
                  <?php foreach (ORDER_STATUSES as $value => $label): ?>
                    <option value="<?= $value ?>" <?= (int) $data['status'] === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                  <?php endforeach; ?>
                </select>
                <small class="text-muted d-block mt-1">Cancelling an order puts its items back in stock.</small>
                <button type="submit" name="updateOrderBtn" class="btn btn-primary mt-2">Update Status</button>
              </form>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
