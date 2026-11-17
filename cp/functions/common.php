<?php
/*
 * Shared helpers used by both the shop and the admin panel.
 * Every page includes this file (through userfunction.php or myfunction.php).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db/config.php';

const UPLOAD_DIR = __DIR__ . '/../upload';
const ORDER_STATUSES = [0 => 'Under Process', 1 => 'Completed', 2 => 'Cancelled'];

/** Escape a value for safe output in HTML (prevents XSS). */
function e($value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/** Format a number as a price, e.g. 120 -> "120.00". */
function money($value): string
{
    return number_format((float) $value, 2);
}

/** Text label for an order status number. */
function statusLabel($status): string
{
    return ORDER_STATUSES[(int) $status] ?? 'Unknown';
}

/** Store a one-off message for the next page and redirect. */
function redirect(string $url, ?string $message = null): void
{
    if ($message !== null) {
        $_SESSION['message'] = $message;
    }
    header('Location: ' . $url);
    exit();
}

/**
 * Run a prepared statement. Values are sent separately from the SQL,
 * so user input can never change the query (prevents SQL injection).
 * Returns a mysqli_result for SELECT queries and true otherwise.
 */
function db_query(string $sql, array $params = [])
{
    global $conn;
    $stmt = mysqli_prepare($conn, $sql);
    if ($params) {
        $types = '';
        foreach ($params as $param) {
            $types .= is_int($param) ? 'i' : (is_float($param) ? 'd' : 's');
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result === false ? true : $result;
}

/** Fetch every row as an associative array. */
function db_all(string $sql, array $params = []): array
{
    return mysqli_fetch_all(db_query($sql, $params), MYSQLI_ASSOC);
}

/** Fetch the first row, or null when nothing matches. */
function db_one(string $sql, array $params = []): ?array
{
    return mysqli_fetch_assoc(db_query($sql, $params)) ?: null;
}

/** Fetch a single value (first column of the first row). */
function db_value(string $sql, array $params = [])
{
    $row = mysqli_fetch_row(db_query($sql, $params));
    return $row ? $row[0] : null;
}

function db_insert_id(): int
{
    global $conn;
    return (int) mysqli_insert_id($conn);
}

/* ---------- Logged-in checks ---------- */

function is_customer(): bool
{
    return !empty($_SESSION['auth']) && !empty($_SESSION['auth_user']['c_id']);
}

function current_customer_id(): int
{
    return is_customer() ? (int) $_SESSION['auth_user']['c_id'] : 0;
}

function require_customer(string $loginUrl = 'loginUi.php'): void
{
    if (!is_customer()) {
        redirect($loginUrl, 'Please log in to continue');
    }
}

function is_admin(): bool
{
    return !empty($_SESSION['authenticate']) && !empty($_SESSION['auth_admin']['a_id']);
}

function require_admin(string $loginUrl = 'adminLogin.php'): void
{
    if (!is_admin()) {
        redirect($loginUrl, 'Please log in as an admin');
    }
}

/** Read a positive whole number from user input, or null if it is not one. */
function positive_int($value): ?int
{
    $int = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $int === false ? null : $int;
}

/** Print the pending flash message as a JS string for alertify, then clear it. */
function flash_script(): void
{
    if (isset($_SESSION['message'])) {
        $message = json_encode((string) $_SESSION['message'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        unset($_SESSION['message']);
        echo "alertify.set('notifier', 'position', 'top-right');\nalertify.message($message);\n";
    }
}

/* ---------- Image uploads ---------- */

/** A problem with an uploaded file that the admin should be told about. */
class UploadException extends RuntimeException
{
}

/**
 * Save an uploaded image into /upload and return its new file name.
 * Returns null when no file was chosen. Only real image files are accepted,
 * so nobody can upload a .php script and run it on the server.
 */
function save_uploaded_image(string $field): ?string
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new UploadException('The image could not be uploaded. Try a smaller file.');
    }
    $extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowed, true) || @getimagesize($_FILES[$field]['tmp_name']) === false) {
        throw new UploadException('Please upload a JPG, PNG, GIF or WEBP image.');
    }
    $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], UPLOAD_DIR . '/' . $fileName)) {
        throw new UploadException('The image could not be saved.');
    }
    return $fileName;
}

/** Delete an uploaded image, unless another product or collection still uses it. */
function delete_upload(?string $fileName): void
{
    if (!$fileName || basename($fileName) !== $fileName) {
        return;
    }
    $stillUsed = (int) db_value(
        'SELECT (SELECT COUNT(*) FROM product WHERE p_image = ?) + (SELECT COUNT(*) FROM collection WHERE colImage = ?)',
        [$fileName, $fileName]
    );
    $path = UPLOAD_DIR . '/' . $fileName;
    if ($stillUsed === 0 && is_file($path)) {
        unlink($path);
    }
}
