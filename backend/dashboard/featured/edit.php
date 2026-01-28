<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../helpers.php';
}

// Require login
requireLogin();

// Get current user
$user = getCurrentUser();

// Get featured content
$result = $conn->query("SELECT * FROM featured WHERE id = 1");
$featured = $result->num_rows > 0 ? $result->fetch_assoc() : null;

$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dotext = sanitizeInput($_POST['dotext'] ?? '');
    $heading = sanitizeInput($_POST['heading'] ?? '');
    $subheading = sanitizeInput($_POST['subheading'] ?? '');
    $details = sanitizeInput($_POST['details'] ?? '');
    
    // Validation
    if (empty($dotext)) $errors[] = 'Do text is required';
    if (empty($heading)) $errors[] = 'Heading is required';
    if (empty($subheading)) $errors[] = 'Subheading is required';
    if (empty($details)) $errors[] = 'Details are required';
    
    if (!$featured && (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE)) {
        $errors[] = 'Image is required for new featured content';
    }
    
    if (empty($errors)) {
        $image = $featured['image'] ?? '';
        
        // Check if new image uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['image'], FEATURED_UPLOAD_PATH);
            
            if ($uploadResult['success']) {
                if ($featured && !empty($featured['image'])) {
                    deleteImage($featured['image'], FEATURED_UPLOAD_PATH);
                }
                $image = $uploadResult['filename'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }
        
        if (empty($errors)) {
            if ($featured) {
                $stmt = $conn->prepare("UPDATE featured SET dotext = ?, heading = ?, subheading = ?, details = ?, image = ? WHERE id = 1");
                $stmt->bind_param("sssss", $dotext, $heading, $subheading, $details, $image);
                $message = 'Featured content updated successfully!';
            } else {
                $stmt = $conn->prepare("INSERT INTO featured (id, dotext, heading, subheading, details, image) VALUES (1, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $dotext, $heading, $subheading, $details, $image);
                $message = 'Featured content created successfully!';
            }
            
            if ($stmt->execute()) {
                setFlashMessage('success', $message);
                header("Location: /nymkalgaon/admin/featured");
                exit();
            } else {
                $errors[] = 'Failed to save featured content';
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
    <title><?php echo $featured ? 'Edit' : 'Create'; ?> Featured Content - NYM Kalgaon Admin</title>
    <link rel="icon" href="../../../images/icons/cricket.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/nymkalgaon/backend/dashboard/assets/admin.css">
    <style>
        .split-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .preview-panel {
            position: sticky;
            top: 100px;
            background: #f9fafb;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }

        .preview-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-content {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .preview-image-container {
            position: relative;
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-image-placeholder {
            color: white;
            font-size: 48px;
            opacity: 0.5;
        }

        .preview-text {
            padding: 30px;
        }

        .preview-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        .preview-heading {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .preview-subheading {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .preview-details {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .preview-details.expanded {
            max-height: 500px;
        }

        .preview-toggle {
            color: #667eea;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .preview-toggle:hover {
            color: #5568d3;
        }

        @media (max-width: 1200px) {
            .split-container {
                grid-template-columns: 1fr;
            }

            .preview-panel {
                position: relative;
                top: 0;
                order: -1;
            }
        }

        .form-panel {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .char-count {
            font-size: 12px;
            color: #9ca3af;
            text-align: right;
            margin-top: 5px;
        }
    </style>
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
                <a href="/nymkalgaon/admin/news" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <span>Manage News</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/nymkalgaon/admin/featured" class="nav-link active">
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
                    <i class="fas fa-star" style="color: var(--warning);"></i>
                    <?php echo $featured ? 'Edit' : 'Create'; ?> Featured Content
                </h1>
            </div>
            <div class="topbar-actions">
                <a href="/nymkalgaon/admin/dashboard" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="content-area">
            <?php 
            $flashMessage = getFlashMessage();
            if ($flashMessage): 
            ?>
                <div class="alert alert-<?php echo $flashMessage['type']; ?>">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($flashMessage['message']); ?>
                </div>
            <?php endif; ?>

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

            <div class="split-container">
                <!-- Form Panel -->
                <div class="form-panel">
                    <h3 style="margin-bottom: 25px;">
                        <i class="fas fa-edit" style="color: var(--primary);"></i>
                        Edit Content
                    </h3>

                    <form method="POST" enctype="multipart/form-data" id="featuredForm">
                        <div class="form-group">
                            <label for="dotext">
                                <i class="fas fa-tag"></i>
                                Badge Text
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="dotext" 
                                name="dotext"
                                placeholder="e.g., FEATURED"
                                value="<?php echo htmlspecialchars($_POST['dotext'] ?? $featured['dotext'] ?? 'FEATURED'); ?>"
                                required
                                maxlength="50"
                            >
                            <div class="char-count"><span id="dotextCount">0</span>/50</div>
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
                                placeholder="Enter main heading"
                                value="<?php echo htmlspecialchars($_POST['heading'] ?? $featured['heading'] ?? 'Snowfall Cup 2026 – Registrations Open'); ?>"
                                required
                                maxlength="100"
                            >
                            <div class="char-count"><span id="headingCount">0</span>/100</div>
                        </div>

                        <div class="form-group">
                            <label for="subheading">
                                <i class="fas fa-align-left"></i>
                                Subheading
                            </label>
                            <textarea 
                                class="form-control" 
                                id="subheading" 
                                name="subheading"
                                placeholder="Enter subheading"
                                rows="3"
                                required
                                maxlength="200"
                            ><?php echo htmlspecialchars($_POST['subheading'] ?? $featured['subheading'] ?? 'The much-awaited Snowfall Cup 2026 registrations are now open. Teams are requested to register before the deadline.'); ?></textarea>
                            <div class="char-count"><span id="subheadingCount">0</span>/200</div>
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
                                placeholder="Enter detailed content"
                                rows="6"
                                required
                            ><?php echo htmlspecialchars($_POST['details'] ?? $featured['details'] ?? "This year's tournament promises an even bigger and better experience with enhanced facilities, improved match scheduling, and participation from top teams across the region. All interested teams must ensure that player details and required documents are submitted during the registration process. Early registration is encouraged as slots are limited and entries will be accepted on a first-come, first-served basis."); ?></textarea>
                            <div class="char-count"><span id="detailsCount">0</span>/1000</div>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-image"></i>
                                Featured Image
                            </label>
                            <div style="text-align: center; padding: 30px; background: #f9fafb; border-radius: 12px; border: 2px dashed #e5e7eb;">
                                <label for="image" class="btn btn-primary" style="cursor: pointer; margin: 0;">
                                    <i class="fas fa-upload"></i> <?php echo $featured && !empty($featured['image']) ? 'Change Image' : 'Upload Image'; ?>
                                </label>
                                <input 
                                    type="file" 
                                    id="image" 
                                    name="image"
                                    accept="image/*"
                                    style="display: none;"
                                    <?php echo !$featured ? 'required' : ''; ?>
                                >
                                <p style="font-size: 12px; color: #9ca3af; margin-top: 10px;">Max: 5MB • JPG, PNG, GIF</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> <?php echo $featured ? 'Update' : 'Create'; ?> Featured Content
                            </button>
                            <a href="/nymkalgaon/admin/dashboard" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Live Preview Panel -->
                <div class="preview-panel">
                    <div class="preview-header">
                        <h3>
                            <i class="fas fa-eye"></i>
                            Live Preview
                        </h3>
                        <span style="font-size: 12px; color: #9ca3af;">Updates as you type</span>
                    </div>

                    <div class="preview-content">
                        <div class="preview-image-container">
                            <?php if ($featured && !empty($featured['image'])): ?>
                                <img src="/nymkalgaon/backend/images/featured/<?php echo htmlspecialchars($featured['image']); ?>" 
                                     alt="Featured" 
                                     class="preview-image"
                                     id="previewImage">
                            <?php else: ?>
                                <i class="fas fa-image preview-image-placeholder" id="previewImagePlaceholder"></i>
                                <img src="" alt="Preview" class="preview-image" id="previewImage" style="display: none;">
                            <?php endif; ?>
                        </div>

                        <div class="preview-text">
                            <span class="preview-badge" id="previewBadge">
                                <?php echo htmlspecialchars($featured['dotext'] ?? 'FEATURED'); ?>
                            </span>
                            <h2 class="preview-heading" id="previewHeading">
                                <?php echo htmlspecialchars($featured['heading'] ?? 'Snowfall Cup 2026 – Registrations Open'); ?>
                            </h2>
                            <p class="preview-subheading" id="previewSubheading">
                                <?php echo htmlspecialchars($featured['subheading'] ?? 'The much-awaited Snowfall Cup 2026 registrations are now open. Teams are requested to register before the deadline.'); ?>
                            </p>
                            <div class="preview-details" id="previewDetails">
                                <?php echo nl2br(htmlspecialchars($featured['details'] ?? "This year's tournament promises an even bigger and better experience with enhanced facilities, improved match scheduling, and participation from top teams across the region.")); ?>
                            </div>
                            <span class="preview-toggle" id="toggleDetails">
                                <span id="toggleText">Show Details</span>
                                <i class="fas fa-chevron-down" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
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

        // Auto-hide flash messages
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }

        // Live Preview Updates
        const dotextInput = document.getElementById('dotext');
        const headingInput = document.getElementById('heading');
        const subheadingInput = document.getElementById('subheading');
        const detailsInput = document.getElementById('details');
        const imageInput = document.getElementById('image');

        const previewBadge = document.getElementById('previewBadge');
        const previewHeading = document.getElementById('previewHeading');
        const previewSubheading = document.getElementById('previewSubheading');
        const previewDetails = document.getElementById('previewDetails');
        const previewImage = document.getElementById('previewImage');
        const previewImagePlaceholder = document.getElementById('previewImagePlaceholder');

        // Character counters
        function updateCharCount(input, countElement) {
            const count = input.value.length;
            countElement.textContent = count;
        }

        dotextInput.addEventListener('input', (e) => {
            previewBadge.textContent = e.target.value || 'FEATURED';
            updateCharCount(e.target, document.getElementById('dotextCount'));
        });

        headingInput.addEventListener('input', (e) => {
            previewHeading.textContent = e.target.value || 'Enter heading...';
            updateCharCount(e.target, document.getElementById('headingCount'));
        });

        subheadingInput.addEventListener('input', (e) => {
            previewSubheading.textContent = e.target.value || 'Enter subheading...';
            updateCharCount(e.target, document.getElementById('subheadingCount'));
        });

        detailsInput.addEventListener('input', (e) => {
            previewDetails.innerHTML = (e.target.value || 'Enter details...').replace(/\n/g, '<br>');
            updateCharCount(e.target, document.getElementById('detailsCount'));
        });

        // Image preview
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    if (previewImagePlaceholder) {
                        previewImagePlaceholder.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Toggle details
        const toggleDetails = document.getElementById('toggleDetails');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleDetails.addEventListener('click', () => {
            previewDetails.classList.toggle('expanded');
            if (previewDetails.classList.contains('expanded')) {
                toggleText.textContent = 'Hide Details';
                toggleIcon.className = 'fas fa-chevron-up';
            } else {
                toggleText.textContent = 'Show Details';
                toggleIcon.className = 'fas fa-chevron-down';
            }
        });

        // Initialize character counts
        updateCharCount(dotextInput, document.getElementById('dotextCount'));
        updateCharCount(headingInput, document.getElementById('headingCount'));
        updateCharCount(subheadingInput, document.getElementById('subheadingCount'));
        updateCharCount(detailsInput, document.getElementById('detailsCount'));
    </script>
</body>
</html>
