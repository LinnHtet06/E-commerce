<?php
/*
 * Database connection.
 *
 * Defaults match a fresh XAMPP install (user "root", no password).
 * You can override any value with environment variables instead of editing
 * this file: DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME.
 */
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = (int) (getenv('DB_PORT') ?: 3306);
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$dbName = getenv('DB_NAME') ?: 'dior_shop';

// Turn database errors into exceptions so they are never silently ignored.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Could not connect to the database. Make sure MySQL is running and that the '
        . 'database has been imported from database/dior_shop.sql (see README.md).');
}
