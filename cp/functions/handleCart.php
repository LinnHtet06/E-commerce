<?php
/*
 * Cart actions called from asset/js/custom.js. Always answers with JSON:
 * { "status": ..., "message": ... }
 */
require_once __DIR__ . '/common.php';

header('Content-Type: application/json');

function respond($status, string $message = ''): void
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

if (!is_customer()) {
    respond(401, 'Please log in to use the cart');
}

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data) || empty($data['scope'])) {
    respond(400, 'Scope not set');
}

$userID = current_customer_id();

try {
    switch ($data['scope']) {
        case 'add':
            $prodId = positive_int($data['prod_id'] ?? null);
            $qty    = positive_int($data['prod_qty'] ?? null);
            if (!$prodId || !$qty) {
                respond(400, 'Product or quantity missing');
            }
            $product = db_one('SELECT p_stock FROM product WHERE p_id = ?', [$prodId]);
            if (!$product) {
                respond(404, 'Product not found');
            }
            if (db_one('SELECT cart_id FROM carts WHERE p_id = ? AND c_id = ?', [$prodId, $userID])) {
                respond('alreadyexisting', 'This product is already in your cart');
            }
            if ($qty > (int) $product['p_stock']) {
                respond(409, $product['p_stock'] > 0 ? "Only {$product['p_stock']} left in stock" : 'Sorry, this product is out of stock');
            }
            db_query('INSERT INTO carts (pqty, p_id, c_id) VALUES (?, ?, ?)', [$qty, $prodId, $userID]);
            respond(201, 'Product added to cart');

        case 'update':
            $cartId = positive_int($data['cartId'] ?? null);
            $qty    = positive_int($data['prod_qty'] ?? null);
            if (!$cartId || !$qty) {
                respond(400, 'Cart item or quantity missing');
            }
            $item = db_one(
                'SELECT p.p_stock FROM carts c JOIN product p ON p.p_id = c.p_id WHERE c.cart_id = ? AND c.c_id = ?',
                [$cartId, $userID]
            );
            if (!$item) {
                respond(404, 'Cart item not found');
            }
            if ($qty > (int) $item['p_stock']) {
                respond(409, "Only {$item['p_stock']} left in stock");
            }
            db_query('UPDATE carts SET pqty = ? WHERE cart_id = ? AND c_id = ?', [$qty, $cartId, $userID]);
            respond(200, 'Quantity updated');

        case 'delete':
            $cartId = positive_int($data['cartId'] ?? null);
            if (!$cartId) {
                respond(400, 'Cart ID not set');
            }
            if (!db_one('SELECT cart_id FROM carts WHERE cart_id = ? AND c_id = ?', [$cartId, $userID])) {
                respond(404, 'Cart item not found');
            }
            db_query('DELETE FROM carts WHERE cart_id = ? AND c_id = ?', [$cartId, $userID]);
            respond(201, 'Product removed from cart');

        default:
            respond(400, 'Invalid scope');
    }
} catch (Throwable $e) {
    error_log('Cart error: ' . $e->getMessage());
    respond(500, 'Something went wrong');
}
