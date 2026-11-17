<?php
/* Slide-out cart, available on every page for logged-in customers. */
$cartItems = getCartItems();
$cartSum = cartTotal($cartItems);
?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Your Cart</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body" id="myCart">
    <?php foreach ($cartItems as $cartItem): ?>
      <div class="row cartItem mb-3" data-cart-id="<?= (int) $cartItem['cID'] ?>" data-price="<?= e($cartItem['p_price']) ?>">
        <div class="col-4">
          <img src="upload/<?= e($cartItem['p_image']) ?>" alt="<?= e($cartItem['p_name']) ?>" class="w-100">
        </div>
        <div class="col-8">
          <h6><?= e($cartItem['p_name']) ?></h6>
          <h6>Size: <?= e($cartItem['p_size']) ?></h6>
          <h6>Price: $<?= money($cartItem['p_price']) ?></h6>
          <div class="input-group mb-2" style="width:140px">
            <button class="input-group-text decrement-btn" type="button" aria-label="Decrease quantity">-</button>
            <input type="text" class="form-control text-center bg-white qty" value="<?= (int) $cartItem['pqty'] ?>" data-max="<?= (int) $cartItem['p_stock'] ?>" readonly>
            <button class="input-group-text increment-btn" type="button" aria-label="Increase quantity">+</button>
          </div>
          <h6>Subtotal: $<span class="lineTotal"><?= money($cartItem['p_price'] * $cartItem['pqty']) ?></span></h6>
          <button class="btn btn-sm btn-danger removeItem" type="button" value="<?= (int) $cartItem['cID'] ?>">Remove</button>
        </div>
        <hr class="mt-3">
      </div>
    <?php endforeach; ?>

    <div id="cartEmpty" class="card card-body shadow text-center <?= $cartItems ? 'd-none' : '' ?>">
      <h4 class="py-3">Your cart is empty</h4>
    </div>

    <a href="checkOut.php" id="cartCheckout" class="btn btn-dark w-100 mt-2 <?= $cartItems ? '' : 'd-none' ?>">
      Proceed to Checkout $<span id="cartTotal"><?= money($cartSum) ?></span>
    </a>
  </div>
</div>
