<?php
require_once __DIR__ . '/../functions/common.php';
unset($_SESSION['authenticate'], $_SESSION['auth_admin']);
session_regenerate_id(true);
redirect('adminLogin.php', 'Logged out successfully');
