<?php
require_once __DIR__ . '/functions/common.php';
unset($_SESSION['auth'], $_SESSION['auth_user']);
session_regenerate_id(true);
redirect('index.php', 'Logged out successfully');
