<?php
/*
 * Wishlist actions called from asset/js/custom.js. Always answers with JSON.
 */
require_once __DIR__ . '/common.php';

header('Content-Type: application/json');

function respond($status, string $message = ''): void
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

if (!is_customer()) {
    respond(401, 'Please log in to use your wishlist');
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
            if (!$prodId || !db_one('SELECT p_id FROM product WHERE p_id = ?', [$prodId])) {
                respond(404, 'Product not found');
            }
            if (db_one('SELECT wish_id FROM wishlist WHERE p_id = ? AND c_id = ?', [$prodId, $userID])) {
                respond('alreadyexisting', 'Already in your wishlist');
            }
            db_query('INSERT INTO wishlist (p_id, c_id) VALUES (?, ?)', [$prodId, $userID]);
            respond(201, 'Product added to wishlist');

        case 'delete':
            $wishId = positive_int($data['wID'] ?? null);
            if (!$wishId || !db_one('SELECT wish_id FROM wishlist WHERE wish_id = ? AND c_id = ?', [$wishId, $userID])) {
                respond(404, 'Wishlist item not found');
            }
            db_query('DELETE FROM wishlist WHERE wish_id = ? AND c_id = ?', [$wishId, $userID]);
            respond(201, 'Product removed from wishlist');

        default:
            respond(400, 'Invalid scope');
    }
} catch (Throwable $e) {
    error_log('Wishlist error: ' . $e->getMessage());
    respond(500, 'Something went wrong');
}
