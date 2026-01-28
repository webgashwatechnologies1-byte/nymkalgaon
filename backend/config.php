<?php
// Start session for authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Database connection
$conn = new mysqli("localhost", "root", "", "nymkalgaon");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Define base paths
define('BASE_PATH', dirname(dirname(__DIR__)));
define('BACKEND_PATH', __DIR__);
define('UPLOAD_PATH', BACKEND_PATH . '/images/');
define('NEWS_UPLOAD_PATH', UPLOAD_PATH . 'news/');
define('FEATURED_UPLOAD_PATH', UPLOAD_PATH . 'featured/');

// Define base URLs
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . "://" . $host . "/nymkalgaon/");
define('BACKEND_URL', BASE_URL . "backend/");
define('DASHBOARD_URL', BACKEND_URL . "dashboard/");
?>
