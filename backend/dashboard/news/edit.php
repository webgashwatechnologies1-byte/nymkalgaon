<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../helpers.php';
}

// Require login
requireLogin();

// Get current user
$user = getCurrentUser();

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

$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news_date = $_POST['news_date'] ?? '';
    $heading = sanitizeInput($_POST['heading'] ?? '');
    $subheading = sanitizeInput($_POST['subheading'] ?? '');
    $details = sanitizeInput($_POST['details'] ?? '');
    
    // Validation
    if (empty($news_date)) $errors[] = 'News date is required';
    if (empty($heading)) $errors[] = 'Heading is required';
    if (empty($subheading)) $errors[] = 'Subheading is required';
    if (empty($details)) $errors[] = 'Details are required';
    
    if (empty($errors)) {
        $image = $news['image']; // Keep existing image by default
        
        // Check if new image uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['image'], NEWS_UPLOAD_PATH);
            
            if ($uploadResult['success']) {
                // Delete old image
                deleteImage($news['image'], NEWS_UPLOAD_PATH);
                $image = $uploadResult['filename'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }
        
        if (empty($errors)) {
            // Update database
            $stmt = $conn->prepare("UPDATE news SET news_date = ?, image = ?, heading = ?, subheading = ?, details = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $news_date, $image, $heading, $subheading, $details, $id);
            
            if ($stmt->execute()) {
                setFlashMessage('success', 'News updated successfully!');
                header("Location: /nymkalgaon/admin/news");
                exit();
            } else {
                $errors[] = 'Failed to update news';
            }
            
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News - NYM Kalgaon Admin</title>
    <link rel="icon" href="../../../images/icons/cricket.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/nymkalgaon/backend/dashboard/assets/admin.css">
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="../../../images/icons/cricket.jpeg" alt="NYM Kalgaon">
            <h3>NYM Kalgaon</h3>
        </div>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="/nymkalgaon/admin/dashboard" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/nymkalgaon/admin/news" class="nav-link active">
                    <i class="fas fa-newspaper"></i>
                    <span>Manage News</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/nymkalgaon/admin/featured" class="nav-link">
                    <i class="fas fa-star"></i>
                    <span>Featured Content</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/nymkalgaon/admin/users/register" class="nav-link">
                    <i class="fas fa-user-plus"></i>
                    <span>Add User</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                </div>
                <div class="user-details">
                    <h4><?php echo htmlspecialchars($user['name']); ?></h4>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
            <a href="/nymkalgaon/admin/logout" class="btn btn-outline" style="width: 100%; justify-content: center;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>
                    <i class="fas fa-edit" style="color: var(--primary);"></i>
                    Edit News
                </h1>
            </div>
            <div class="topbar-actions">
                <a href="/nymkalgaon/admin/news" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>
            </div>
        </div>

        <div class="content-area">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <?php foreach ($errors as $error): ?>
                            <div><?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <h3>
                    <i class="fas fa-newspaper" style="color: var(--primary);"></i>
                    News Information
                </h3>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="news_date">
                                    <i class="fas fa-calendar"></i>
                                    News Date
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="news_date" 
                                    name="news_date"
                                    value="<?php echo htmlspecialchars($_POST['news_date'] ?? $news['news_date']); ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">
                                    <i class="fas fa-image"></i>
                                    News Image (Leave empty to keep current)
                                </label>
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    id="image" 
                                    name="image"
                                    accept="image/*"
                                >
                                <small class="form-text">Max size: 5MB. Formats: JPG, PNG, GIF</small>
                                <?php if (!empty($news['image'])): ?>
                                    <img src="../../images/news/<?php echo htmlspecialchars($news['image']); ?>" 
                                         alt="Current" 
                                         class="current-image"
                                         id="currentImage">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="heading">
                            <i class="fas fa-heading"></i>
                            Heading
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="heading" 
                            name="heading"
                            placeholder="Enter news heading"
                            value="<?php echo htmlspecialchars($_POST['heading'] ?? $news['heading']); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="subheading">
                            <i class="fas fa-align-left"></i>
                            Subheading
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="subheading" 
                            name="subheading"
                            placeholder="Enter news subheading"
                            value="<?php echo htmlspecialchars($_POST['subheading'] ?? $news['subheading']); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="details">
                            <i class="fas fa-file-alt"></i>
                            Details
                        </label>
                        <textarea 
                            class="form-control" 
                            id="details" 
                            name="details"
                            placeholder="Enter detailed news content"
                            rows="6"
                            required
                        ><?php echo htmlspecialchars($_POST['details'] ?? $news['details']); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update News
                        </button>
                        <a href="/nymkalgaon/admin/news" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentImage = document.getElementById('currentImage');
                    if (currentImage) {
                        currentImage.src = e.target.result;
                    } else {
                        const preview = document.createElement('img');
                        preview.id = 'currentImage';
                        preview.className = 'current-image';
                        preview.src = e.target.result;
                        document.getElementById('image').parentElement.appendChild(preview);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
