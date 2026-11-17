<?php
/*
 * Handles the customer register/login forms and the admin login/register forms.
 * Passwords are stored with password_hash() and checked with password_verify().
 */
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../index.php');
}

/**
 * Check a password against the stored value. Accounts created by the old
 * version of the site stored plain text (customers) or MD5 (admins); those
 * still work once and are upgraded to a secure hash on the next login.
 */
function check_password(string $password, string $stored, string $table, string $idColumn, int $id): bool
{
    $info = password_get_info($stored);
    if ($info['algo'] !== null && $info['algo'] !== 0) {
        return password_verify($password, $stored);
    }
    $legacyMatch = hash_equals($stored, $password) || hash_equals($stored, md5($password));
    if ($legacyMatch) {
        $passwordColumn = $table === 'admin' ? 'a_password' : 'c_password';
        db_query("UPDATE $table SET $passwordColumn = ? WHERE $idColumn = ?", [password_hash($password, PASSWORD_DEFAULT), $id]);
    }
    return $legacyMatch;
}

// ---------- Customer registration ----------
if (isset($_POST['submit'])) {
    $name    = trim($_POST['name'] ?? '');
    $mail    = trim($_POST['mail'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $pass    = $_POST['pass'] ?? '';
    $cpass   = $_POST['cpass'] ?? '';

    if ($name === '' || $phone === '' || $address === '' || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        redirect('../register.php', 'Please fill in every field with valid details');
    }
    if (strlen($pass) < 6) {
        redirect('../register.php', 'Password must be at least 6 characters');
    }
    if ($pass !== $cpass) {
        redirect('../register.php', 'Passwords do not match');
    }
    if (db_one('SELECT c_id FROM customer WHERE c_email = ?', [$mail])) {
        redirect('../register.php', 'An account with this email already exists');
    }

    db_query(
        'INSERT INTO customer (c_name, c_email, c_phone, c_address, c_password) VALUES (?, ?, ?, ?, ?)',
        [$name, $mail, $phone, $address, password_hash($pass, PASSWORD_DEFAULT)]
    );
    redirect('../loginUi.php', 'Registered successfully. Please log in.');
}

// ---------- Customer login ----------
if (isset($_POST['logIn'])) {
    $mail = trim($_POST['mail'] ?? '');
    $pass = $_POST['pass'] ?? '';

    $user = db_one('SELECT * FROM customer WHERE c_email = ?', [$mail]);
    if (!$user || !check_password($pass, $user['c_password'], 'customer', 'c_id', (int) $user['c_id'])) {
        redirect('../loginUi.php', 'Incorrect email or password');
    }

    session_regenerate_id(true);
    $_SESSION['auth'] = true;
    $_SESSION['auth_user'] = [
        'c_id'    => (int) $user['c_id'],
        'c_name'  => $user['c_name'],
        'c_email' => $user['c_email'],
    ];
    redirect('../index.php', 'Logged in successfully');
}

// ---------- Admin login ----------
if (isset($_POST['AdminLogin'])) {
    $mail = trim($_POST['mail'] ?? '');
    $pass = $_POST['pass'] ?? '';

    $admin = db_one('SELECT * FROM admin WHERE a_email = ?', [$mail]);
    if (!$admin || !check_password($pass, $admin['a_password'], 'admin', 'a_id', (int) $admin['a_id'])) {
        redirect('../admin/adminLogin.php', 'Incorrect email or password');
    }

    session_regenerate_id(true);
    $_SESSION['authenticate'] = true;
    $_SESSION['auth_admin'] = [
        'a_id'    => (int) $admin['a_id'],
        'a_name'  => $admin['a_name'],
        'a_email' => $admin['a_email'],
    ];
    redirect('../admin/index.php', 'Logged in successfully');
}

// ---------- Admin registration ----------
// Only a logged-in admin can create another admin (or anyone, if no admin exists yet).
if (isset($_POST['Adminsubmit'])) {
    $noAdminsYet = (int) db_value('SELECT COUNT(*) FROM admin') === 0;
    if (!is_admin() && !$noAdminsYet) {
        redirect('../admin/adminLogin.php', 'Only a logged-in admin can add new admins');
    }

    $name   = trim($_POST['name'] ?? '');
    $mail   = trim($_POST['mail'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $pass   = $_POST['pass'] ?? '';
    $cpass  = $_POST['cpass'] ?? '';

    if ($name === '' || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        redirect('../admin/adminRegister.php', 'Please enter a name and a valid email');
    }
    if (strlen($pass) < 6) {
        redirect('../admin/adminRegister.php', 'Password must be at least 6 characters');
    }
    if ($pass !== $cpass) {
        redirect('../admin/adminRegister.php', 'Passwords do not match');
    }
    if (db_one('SELECT a_id FROM admin WHERE a_email = ?', [$mail])) {
        redirect('../admin/adminRegister.php', 'Email already exists');
    }

    db_query(
        'INSERT INTO admin (a_name, a_email, a_gender, a_password) VALUES (?, ?, ?, ?)',
        [$name, $mail, $gender, password_hash($pass, PASSWORD_DEFAULT)]
    );
    redirect(is_admin() ? '../admin/index.php' : '../admin/adminLogin.php', 'Admin account created');
}

redirect('../index.php');
