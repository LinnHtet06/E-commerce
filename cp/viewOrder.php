<?php
require_once __DIR__ . '/functions/userfunction.php';
require_customer();

$data = isset($_GET['t']) ? getMyOrder((string) $_GET['t']) : null;
if (!$data) {
    redirect('myOrder.php', 'Order not found');
}
$lines = getOrderLines((int) $data['o_id']);
$pageTitle = 'Order ' . $data['tracking_no'] . ' | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-3">
  <div class="container">
    <h6 class="text-black">
      <a class="text-black" href="index.php">Home</a> /
      <a class="text-black" href="myOrder.php">My Orders</a> /
      View Order
    </h6>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <span class="fs-3 fw-bold">View Order</span>
        <a href="myOrder.php" class="btn btn-warning float-end"><i class="bi bi-reply"></i> Back</a>
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
            ];
            foreach ($fields as $label => $value): ?>
              <div class="mb-2">
                <label class="fw-bold"><?= e($label) ?></label>
                <div class="border p-1"><?= e($value) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col-md-6">
            <h4>Order Details</h4><hr>
            <table class="table">
              <thead>
                <tr><th>Product</th><th>Price</th><th>Quantity</th></tr>
              </thead>
              <tbody>
                <?php foreach ($lines as $item): ?>
                  <tr>
                    <td class="align-middle">
                      <?php if ($item['p_image']): ?>
                        <img src="upload/<?= e($item['p_image']) ?>" alt="<?= e($item['oi_name']) ?>" width="50" height="50">
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
            <h5>Total Price: <span class="float-end fw-bold">$<?= money($data['o_totalAmount']) ?></span></h5>
            <div class="p-1 mb-3"><span class="fw-bold">Payment Mode:</span> <?= e($data['payment_mode']) ?></div>
            <div class="p-1 mb-3"><span class="fw-bold">Status:</span> <?= e(statusLabel($data['status'])) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
