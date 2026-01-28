<?php
// Define backend paths for proper file inclusion
define('BACKEND_ROOT', __DIR__ . '/backend');

// Include backend configuration for admin routes (load once)
require_once BACKEND_ROOT . '/config.php';
require_once BACKEND_ROOT . '/helpers.php';

// Get the requested URI and remove query string
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);

// Remove the base path from the request URI
$route = str_replace($script_name, '', $request_uri);
$route = strtok($route, '?'); // Remove query string
$route = trim($route, '/'); // Remove leading/trailing slashes

// Define public routes (frontend)
$publicRoutes = [
    '' => 'home.php',
    'home' => 'home.php',
    'about' => 'about.php',
    'contact' => 'contact.php',
    'officials' => 'official.php',
    'news-letter' => 'news-&-letter.php',
    'privacy-policy' => 'privacy-policy.php',
    'terms-condition' => 'terms-&-consition.php',
    'thanks' => 'thanks.php',
];

// Define admin routes (backend) - all start with 'admin/'
$adminRoutes = [
    // Authentication
    'admin/login' => 'backend/dashboard/login.php',
    'admin/logout' => 'backend/dashboard/logout.php',
    
    // Dashboard
    'admin' => 'backend/dashboard/dashboard.php',
    'admin/dashboard' => 'backend/dashboard/dashboard.php',
    
    // News Management
    'admin/news' => 'backend/dashboard/news/index.php',
    'admin/news/add' => 'backend/dashboard/news/add.php',
    'admin/news/edit' => 'backend/dashboard/news/edit.php',
    'admin/news/delete' => 'backend/dashboard/news/delete.php',
    
    // Featured Content
    'admin/featured' => 'backend/dashboard/featured/edit.php',
    'admin/featured/edit' => 'backend/dashboard/featured/edit.php',
    
    // User Management
    'admin/users/register' => 'backend/dashboard/users/register.php',
];

// Routes that don't require authentication
$publicAdminRoutes = [
    'admin/login',
];

// Check if it's an admin route
if (strpos($route, 'admin') === 0) {
    // Admin route handling
    if (array_key_exists($route, $adminRoutes)) {
        $file = $adminRoutes[$route];
        
        // Check if authentication is required
        if (!in_array($route, $publicAdminRoutes)) {
            // Require login for all admin routes except login page
            if (!isLoggedIn()) {
                header("Location: /nymkalgaon/admin/login");
                exit();
            }
        }
        
        // Check if file exists
        if (file_exists($file)) {
            include $file;
        } else {
            // File not found
            http_response_code(404);
            echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page Not Found</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div class='container text-center' style='margin-top: 100px;'>
        <h1>404 - Admin Page Not Found</h1>
        <p>The admin page you are looking for does not exist.</p>
        <a href='/nymkalgaon/admin' class='btn btn-primary'>Go to Dashboard</a>
    </div>
</body>
</html>";
        }
    } else {
        // Admin route not found - 404
        http_response_code(404);
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page Not Found</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div class='container text-center' style='margin-top: 100px;'>
        <h1>404 - Admin Route Not Found</h1>
        <p>The requested admin route does not exist.</p>
        <a href='/nymkalgaon/admin' class='btn btn-primary'>Go to Dashboard</a>
    </div>
</body>
</html>";
    }
} else {
    // Public route handling
    if (array_key_exists($route, $publicRoutes)) {
        $file = $publicRoutes[$route];
        
        // Check if file exists
        if (file_exists($file)) {
            include $file;
        } else {
            // File not found
            http_response_code(404);
            echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page Not Found</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div class='container text-center' style='margin-top: 100px;'>
        <h1>404 - Page Not Found</h1>
        <p>The page you are looking for does not exist.</p>
        <a href='/' class='btn btn-primary'>Go to Home</a>
    </div>
</body>
</html>";
        }
    } else {
        // Public route not found - 404
        http_response_code(404);
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page Not Found</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div class='container text-center' style='margin-top: 100px;'>
        <h1>404 - Page Not Found</h1>
        <p>The requested route does not exist.</p>
        <a href='/' class='btn btn-primary'>Go to Home</a>
    </div>
</body>
</html>";
    }
}
?>
