<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../helpers.php';
}

// Require login
requireLogin();

// Get news ID
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    setFlashMessage('error', 'Invalid news ID');
    header("Location: /nymkalgaon/admin/news");
    exit();
}

// Get news data
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    setFlashMessage('error', 'News not found');
    header("Location: /nymkalgaon/admin/news");
    exit();
}

$news = $result->fetch_assoc();
$stmt->close();

// Delete news
$stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Delete image file
    deleteImage($news['image'], NEWS_UPLOAD_PATH);
    
    setFlashMessage('success', 'News deleted successfully!');
} else {
    setFlashMessage('error', 'Failed to delete news');
}

$stmt->close();

// Redirect back to list
header("Location: /nymkalgaon/admin/news");
exit();
?>
