<?php
/*
 * Turns the customer's cart into an order.
 * Everything happens in one database transaction, so an order is either saved
 * completely (order, line items, stock change, empty cart) or not at all.
 */
require_once __DIR__ . '/common.php';

require_customer('../loginUi.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['placeOrder-btn'])) {
    redirect('../checkOut.php');
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$pincode = trim($_POST['pincode'] ?? '');
$address = trim($_POST['address'] ?? '');
$paymentMode = 'Pay on delivery';

if ($name === '' || $phone === '' || $address === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect('../checkOut.php', 'Please fill in your name, a valid email, phone and address');
}

$cusID = current_customer_id();

mysqli_begin_transaction($conn);
try {
    // Lock the cart's products so two orders can't sell the same last bottle.
    $items = db_all(
        'SELECT c.pqty, p.p_id, p.p_name, p.p_price, p.p_stock
         FROM carts c JOIN product p ON p.p_id = c.p_id
         WHERE c.c_id = ? FOR UPDATE',
        [$cusID]
    );

    if (!$items) {
        mysqli_rollback($conn);
        redirect('../index.php', 'Your cart is empty');
    }

    $totalPrice = 0;
    foreach ($items as $item) {
        if ($item['pqty'] > $item['p_stock']) {
            mysqli_rollback($conn);
            $left = (int) $item['p_stock'];
            redirect('../checkOut.php', "Sorry, only $left left of {$item['p_name']}. Please update your cart.");
        }
        $totalPrice += $item['p_price'] * $item['pqty'];
    }

    $digits = preg_replace('/\D/', '', $phone);
    $trackingNo = 'DIOR' . random_int(100000, 999999) . substr($digits, -4);

    db_query(
        'INSERT INTO orders (tracking_no, c_id, name, email, phone, address, pincode, o_totalAmount, payment_mode, payment_id, status)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)',
        [$trackingNo, $cusID, $name, $email, $phone, $address, $pincode, (float) $totalPrice, $paymentMode, 'N/A']
    );
    $orderId = db_insert_id();

    foreach ($items as $item) {
        db_query(
            'INSERT INTO order_items (oi_quantity, oi_price, oi_name, o_id, p_id) VALUES (?, ?, ?, ?, ?)',
            [(int) $item['pqty'], (float) $item['p_price'], $item['p_name'], $orderId, (int) $item['p_id']]
        );
        db_query('UPDATE product SET p_stock = p_stock - ? WHERE p_id = ?', [(int) $item['pqty'], (int) $item['p_id']]);
    }

    db_query('DELETE FROM carts WHERE c_id = ?', [$cusID]);
    mysqli_commit($conn);
} catch (Throwable $e) {
    mysqli_rollback($conn);
    error_log('Order failed: ' . $e->getMessage());
    redirect('../checkOut.php', 'Something went wrong placing your order. Please try again.');
}

redirect('../viewOrder.php?t=' . urlencode($trackingNo), 'Order placed successfully');
