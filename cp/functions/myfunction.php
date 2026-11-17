<?php
/* Data functions for the admin panel. */
require_once __DIR__ . '/common.php';

function getAllProducts(): array
{
    return db_all(
        'SELECT p.*, c.colName FROM product p JOIN collection c ON c.collectionID = p.collectionID ORDER BY p.p_id'
    );
}

function getAllCollections(): array
{
    return db_all('SELECT * FROM collection ORDER BY collectionID');
}

function getProduct(int $id): ?array
{
    return db_one('SELECT * FROM product WHERE p_id = ?', [$id]);
}

function getCollection(int $id): ?array
{
    return db_one('SELECT * FROM collection WHERE collectionID = ?', [$id]);
}

/** Orders that still need handling (status 0 = Under Process). */
function getPendingOrders(): array
{
    return db_all('SELECT * FROM orders WHERE status = 0 ORDER BY o_id DESC');
}

/** Completed and cancelled orders. */
function getOrderHistory(): array
{
    return db_all('SELECT * FROM orders WHERE status <> 0 ORDER BY o_id DESC');
}

function getOrderByTracking(string $trackingNumber): ?array
{
    return db_one('SELECT * FROM orders WHERE tracking_no = ?', [$trackingNumber]);
}

function getOrderLines(int $orderId): array
{
    return db_all(
        'SELECT oi.*, p.p_image FROM order_items oi LEFT JOIN product p ON p.p_id = oi.p_id WHERE oi.o_id = ?',
        [$orderId]
    );
}

function getDashboardStats(): array
{
    return [
        'products'    => (int) db_value('SELECT COUNT(*) FROM product'),
        'collections' => (int) db_value('SELECT COUNT(*) FROM collection'),
        'customers'   => (int) db_value('SELECT COUNT(*) FROM customer'),
        'pending'     => (int) db_value('SELECT COUNT(*) FROM orders WHERE status = 0'),
        'orders'      => (int) db_value('SELECT COUNT(*) FROM orders'),
        'revenue'     => (float) db_value('SELECT COALESCE(SUM(o_totalAmount), 0) FROM orders WHERE status <> 2'),
        'lowStock'    => db_all('SELECT p_id, p_name, p_stock FROM product WHERE p_stock <= 5 ORDER BY p_stock, p_name'),
        'recent'      => db_all('SELECT * FROM orders ORDER BY o_id DESC LIMIT 5'),
    ];
}
