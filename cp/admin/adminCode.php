<?php
/*
 * Handles every admin form: add/edit/delete products and collections,
 * and changing an order's status. Only logged-in admins get past require_admin().
 */
require_once __DIR__ . '/../functions/myfunction.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

/** Read and check the product form. Sends the admin back with a message if something is wrong. */
function product_input(string $backUrl): array
{
    $name   = trim($_POST['name'] ?? '');
    $price  = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
    $stock  = filter_var($_POST['stockqty'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $colID  = positive_int($_POST['collectionID'] ?? null);

    if ($name === '' || $price === false || $price < 0 || $stock === false) {
        redirect($backUrl, 'Please enter a name, a valid price and a whole-number stock quantity');
    }
    if (!$colID || !getCollection($colID)) {
        redirect($backUrl, 'Please choose a collection');
    }

    $date = function (string $field): ?string {
        $value = trim($_POST[$field] ?? '');
        $parsed = DateTime::createFromFormat('Y-m-d', $value);
        return $parsed && $parsed->format('Y-m-d') === $value ? $value : null;
    };

    return [
        'name'        => $name,
        'price'       => (float) $price,
        'stock'       => (int) $stock,
        'collection'  => $colID,
        'size'        => trim($_POST['size'] ?? ''),
        'note'        => trim($_POST['note'] ?? ''),
        'production'  => $date('productionDate'),
        'expiration'  => $date('expirationDate'),
        'ingredients' => trim($_POST['ingredients'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
    ];
}

$errorUrl = 'index.php'; // where to go back to if an image upload fails

try {
    // ---------- Add product ----------
    if (isset($_POST['addProduct'])) {
        $errorUrl = 'products.php';
        $p = product_input($errorUrl);
        $image = save_uploaded_image('image');
        if (!$image) {
            redirect('products.php', 'Please choose an image for the product');
        }
        db_query(
            'INSERT INTO product (p_name, p_price, p_description, p_image, p_stock, p_note, p_productionDate, p_expirationDate, p_size, p_ingredients, collectionID)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$p['name'], $p['price'], $p['description'], $image, $p['stock'], $p['note'], $p['production'], $p['expiration'], $p['size'], $p['ingredients'], $p['collection']]
        );
        redirect('products.php', 'Product added');
    }

    // ---------- Update product ----------
    if (isset($_POST['updateProduct'])) {
        $id = positive_int($_POST['productID'] ?? null);
        $existing = $id ? getProduct($id) : null;
        if (!$existing) {
            redirect('products.php', 'Product not found');
        }
        $backUrl = $errorUrl = 'editProduct.php?id=' . $id;
        $p = product_input($backUrl);
        $newImage = save_uploaded_image('image');
        db_query(
            'UPDATE product SET p_name = ?, p_price = ?, p_description = ?, p_image = ?, p_stock = ?, p_note = ?,
                p_productionDate = ?, p_expirationDate = ?, p_size = ?, p_ingredients = ?, collectionID = ?
             WHERE p_id = ?',
            [$p['name'], $p['price'], $p['description'], $newImage ?? $existing['p_image'], $p['stock'], $p['note'],
             $p['production'], $p['expiration'], $p['size'], $p['ingredients'], $p['collection'], $id]
        );
        if ($newImage) {
            delete_upload($existing['p_image']);
        }
        redirect($backUrl, 'Product updated');
    }

    // ---------- Delete product ----------
    if (isset($_POST['deleteProduct'])) {
        $id = positive_int($_POST['productID'] ?? null);
        $existing = $id ? getProduct($id) : null;
        if ($existing) {
            db_query('DELETE FROM product WHERE p_id = ?', [$id]);
            delete_upload($existing['p_image']);
        }
        redirect('products.php', $existing ? 'Product deleted' : 'Product not found');
    }

    // ---------- Add collection ----------
    if (isset($_POST['addCollection'])) {
        $errorUrl = 'collections.php';
        $name = trim($_POST['colName'] ?? '');
        if ($name === '') {
            redirect('collections.php', 'Please enter a collection name');
        }
        if (db_one('SELECT collectionID FROM collection WHERE colName = ?', [$name])) {
            redirect('collections.php', 'A collection with this name already exists');
        }
        $image = save_uploaded_image('image');
        if (!$image) {
            redirect('collections.php', 'Please choose an image for the collection');
        }
        db_query(
            'INSERT INTO collection (colName, colDescription, limitedEdition, colImage) VALUES (?, ?, ?, ?)',
            [$name, trim($_POST['colDescription'] ?? ''), isset($_POST['Lte']) ? 1 : 0, $image]
        );
        redirect('collections.php', 'Collection added');
    }

    // ---------- Update collection ----------
    if (isset($_POST['editCollection'])) {
        $id = positive_int($_POST['colID'] ?? null);
        $existing = $id ? getCollection($id) : null;
        if (!$existing) {
            redirect('collections.php', 'Collection not found');
        }
        $backUrl = $errorUrl = 'editCollection.php?id=' . $id;
        $name = trim($_POST['colName'] ?? '');
        if ($name === '') {
            redirect($backUrl, 'Please enter a collection name');
        }
        if (db_one('SELECT collectionID FROM collection WHERE colName = ? AND collectionID <> ?', [$name, $id])) {
            redirect($backUrl, 'A collection with this name already exists');
        }
        $newImage = save_uploaded_image('image');
        db_query(
            'UPDATE collection SET colName = ?, colDescription = ?, limitedEdition = ?, colImage = ? WHERE collectionID = ?',
            [$name, trim($_POST['colDescription'] ?? ''), isset($_POST['Lte']) ? 1 : 0, $newImage ?? $existing['colImage'], $id]
        );
        if ($newImage) {
            delete_upload($existing['colImage']);
        }
        redirect($backUrl, 'Collection updated');
    }

    // ---------- Delete collection (its products are deleted too) ----------
    if (isset($_POST['deleteColBtn'])) {
        $id = positive_int($_POST['collectionID'] ?? null);
        $existing = $id ? getCollection($id) : null;
        if ($existing) {
            $productImages = array_column(db_all('SELECT p_image FROM product WHERE collectionID = ?', [$id]), 'p_image');
            db_query('DELETE FROM collection WHERE collectionID = ?', [$id]);
            delete_upload($existing['colImage']);
            foreach ($productImages as $image) {
                delete_upload($image);
            }
        }
        redirect('collections.php', $existing ? 'Collection deleted' : 'Collection not found');
    }

    // ---------- Change order status ----------
    // Cancelling an order puts its items back in stock; un-cancelling takes them out again.
    if (isset($_POST['updateOrderBtn'])) {
        $trackingNumber = (string) ($_POST['trackingNumber'] ?? '');
        $status = filter_var($_POST['orderStatus'] ?? '', FILTER_VALIDATE_INT);
        $order = getOrderByTracking($trackingNumber);
        if (!$order || !array_key_exists($status, ORDER_STATUSES)) {
            redirect('order.php', 'Order not found');
        }
        $backUrl = 'viewOrder.php?t=' . urlencode($trackingNumber);

        mysqli_begin_transaction($conn);
        $wasCancelled = (int) $order['status'] === 2;
        $isCancelled  = $status === 2;
        if ($wasCancelled !== $isCancelled) {
            $sign = $isCancelled ? '+' : '-';
            db_query(
                "UPDATE product p JOIN order_items oi ON oi.p_id = p.p_id
                 SET p.p_stock = p.p_stock $sign oi.oi_quantity WHERE oi.o_id = ?",
                [(int) $order['o_id']]
            );
        }
        db_query('UPDATE orders SET status = ? WHERE o_id = ?', [$status, (int) $order['o_id']]);
        mysqli_commit($conn);
        redirect($backUrl, 'Order status updated');
    }
} catch (UploadException $e) {
    // Upload problems (wrong file type etc.) are shown to the admin.
    redirect($errorUrl, $e->getMessage());
} catch (Throwable $e) {
    try { mysqli_rollback($conn); } catch (Throwable $ignored) {} // undo any half-finished change
    error_log('Admin action failed: ' . $e->getMessage());
    redirect('index.php', 'Something went wrong');
}

redirect('index.php');
