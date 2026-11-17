<?php
/* Data functions for the customer-facing shop. */
require_once __DIR__ . '/common.php';

function getCollections(): array
{
    return db_all('SELECT * FROM collection ORDER BY collectionID');
}

function getCollectionByName(string $name): ?array
{
    return db_one('SELECT * FROM collection WHERE colName = ? LIMIT 1', [$name]);
}

function getProductsByCollection(int $collectionId): array
{
    return db_all('SELECT * FROM product WHERE collectionID = ? ORDER BY p_id', [$collectionId]);
}

function getProductById(int $productId): ?array
{
    return db_one(
        'SELECT p.*, c.colName FROM product p JOIN collection c ON c.collectionID = p.collectionID WHERE p.p_id = ?',
        [$productId]
    );
}

function getProductByName(string $name): ?array
{
    return db_one(
        'SELECT p.*, c.colName FROM product p JOIN collection c ON c.collectionID = p.collectionID WHERE p.p_name = ? LIMIT 1',
        [$name]
    );
}

/** Items in the logged-in customer's cart (empty for guests). */
function getCartItems(): array
{
    if (!is_customer()) {
        return [];
    }
    return db_all(
        'SELECT c.cart_id AS cID, c.pqty, p.p_id, p.p_name, p.p_size, p.p_image, p.p_price, p.p_stock
         FROM carts c JOIN product p ON p.p_id = c.p_id
         WHERE c.c_id = ? ORDER BY c.cart_id DESC',
        [current_customer_id()]
    );
}

function cartTotal(array $items): float
{
    $total = 0.0;
    foreach ($items as $item) {
        $total += $item['p_price'] * $item['pqty'];
    }
    return $total;
}

function getWishItems(): array
{
    return db_all(
        'SELECT w.wish_id AS wID, p.p_id, p.p_name, p.p_size, p.p_image, p.p_price
         FROM wishlist w JOIN product p ON p.p_id = w.p_id
         WHERE w.c_id = ? ORDER BY w.wish_id DESC',
        [current_customer_id()]
    );
}

function getCustomer(): ?array
{
    return db_one('SELECT c_name, c_email, c_phone, c_address FROM customer WHERE c_id = ?', [current_customer_id()]);
}

function getMyOrders(): array
{
    return db_all('SELECT * FROM orders WHERE c_id = ? ORDER BY o_id DESC', [current_customer_id()]);
}

/** One of the logged-in customer's orders, looked up by tracking number. */
function getMyOrder(string $trackingNumber): ?array
{
    return db_one('SELECT * FROM orders WHERE tracking_no = ? AND c_id = ?', [$trackingNumber, current_customer_id()]);
}

function getOrderLines(int $orderId): array
{
    return db_all(
        'SELECT oi.*, p.p_image FROM order_items oi LEFT JOIN product p ON p.p_id = oi.p_id WHERE oi.o_id = ?',
        [$orderId]
    );
}
