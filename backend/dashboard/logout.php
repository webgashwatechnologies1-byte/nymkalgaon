<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../helpers.php';
}

// Destroy session and logout
session_destroy();

// Redirect to login page
header("Location: /nymkalgaon/admin/login");
exit();
?>
