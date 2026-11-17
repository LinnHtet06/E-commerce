<?php
require_once __DIR__ . '/functions/userfunction.php';
require_customer();

$items = getCartItems();
if (!$items) {
    redirect('index.php', 'Your cart is empty');
}
$totalPrice = cartTotal($items);
$customer = getCustomer() ?? [];
$pageTitle = 'Checkout | Dior';
include __DIR__ . '/include/header.php';
?>
<div class="py-3">
  <div class="container">
    <h6 class="text-black">
      <a class="text-black" href="index.php">Home</a> / Checkout
    </h6>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="card">
      <div class="card-body shadow">
        <form action="functions/placeOrder.php" method="POST">
          <div class="row">
            <div class="col-md-7">
              <h5>Details</h5><hr>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name" class="fw-bold">Name</label>
                  <input type="text" required name="name" id="name" value="<?= e($customer['c_name'] ?? '') ?>" placeholder="Enter your full name" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="fw-bold">Email</label>
                  <input type="email" required name="email" id="email" value="<?= e($customer['c_email'] ?? '') ?>" placeholder="Enter your email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone" class="fw-bold">Phone</label>
                  <input type="tel" required name="phone" id="phone" value="<?= e($customer['c_phone'] ?? '') ?>" placeholder="Enter your phone number" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="pincode" class="fw-bold">Postal code (optional)</label>
                  <input type="text" name="pincode" id="pincode" maxlength="20" placeholder="Enter your postal code" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                  <label for="address" class="fw-bold">Address</label>
                  <textarea required name="address" id="address" class="form-control" rows="3"><?= e($customer['c_address'] ?? '') ?></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <h5>Cart Items</h5><hr>
              <div class="row align-items-center">
                <div class="col-5"><h6>Product</h6></div>
                <div class="col-4"><h6>Price</h6></div>
                <div class="col-3"><h6>Qty</h6></div>
              </div>
              <?php foreach ($items as $item): ?>
                <div class="card shadow-sm mb-3">
                  <div class="row align-items-center g-2 p-2">
                    <div class="col-2">
                      <img src="upload/<?= e($item['p_image']) ?>" alt="<?= e($item['p_name']) ?>" class="w-100">
                    </div>
                    <div class="col-3"><h6 class="mb-0"><?= e($item['p_name']) ?></h6></div>
                    <div class="col-4"><h6 class="mb-0">$<?= money($item['p_price']) ?></h6></div>
                    <div class="col-3"><h6 class="mb-0"><?= (int) $item['pqty'] ?></h6></div>
                  </div>
                </div>
              <?php endforeach; ?>
              <hr>
              <h5>Total Price: <span class="float-end fw-bold">$<?= money($totalPrice) ?></span></h5>
              <p class="text-muted small">Payment is taken on delivery (this demo shop has no card payments).</p>
              <button name="placeOrder-btn" type="submit" class="btn btn-dark w-100">
                Place Order $<?= money($totalPrice) ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/include/footer.php'; ?>
