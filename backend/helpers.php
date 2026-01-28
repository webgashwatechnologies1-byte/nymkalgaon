<?php
// Helper functions for backend

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require login - redirect to login page if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /nymkalgaon/admin/login");
        exit();
    }
}

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Upload image file
 * @param array $file - $_FILES array element
 * @param string $uploadDir - Directory to upload to
 * @param array $allowedTypes - Allowed MIME types
 * @param int $maxSize - Max file size in bytes (default 5MB)
 * @return array - ['success' => bool, 'filename' => string, 'error' => string]
 */
function uploadImage($file, $uploadDir, $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'], $maxSize = 5242880) {
    $result = ['success' => false, 'filename' => '', 'error' => ''];
    
    // Check if file was uploaded
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $result['error'] = 'No file uploaded';
        return $result;
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'Upload error: ' . $file['error'];
        return $result;
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        $result['error'] = 'File too large. Maximum size: ' . ($maxSize / 1024 / 1024) . 'MB';
        return $result;
    }
    
    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        $result['error'] = 'Invalid file type. Allowed: JPG, PNG, GIF';
        return $result;
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $targetPath = $uploadDir . $filename;
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $result['success'] = true;
        $result['filename'] = $filename;
    } else {
        $result['error'] = 'Failed to move uploaded file';
    }
    
    return $result;
}

/**
 * Delete image file
 * @param string $filename - Filename to delete
 * @param string $directory - Directory containing the file
 * @return bool
 */
function deleteImage($filename, $directory) {
    if (empty($filename)) {
        return false;
    }
    
    $filepath = $directory . $filename;
    
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    
    return false;
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * Get user info from session
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? ''
        ];
    }
    return null;
}

/**
 * Set flash message
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type, // success, error, warning, info
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}
?>
