<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../helpers.php';
}

// Require login
requireLogin();

// Get current user
$user = getCurrentUser();

// Get all news
$result = $conn->query("SELECT * FROM news ORDER BY news_date DESC, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News - NYM Kalgaon Admin</title>
    <link rel="icon" href="../../../images/icons/cricket.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/nymkalgaon/backend/dashboard/assets/admin.css">
</head>
<body>
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>
                    <i class="fas fa-newspaper" style="color: var(--primary);"></i>
                    Manage News
                </h1>
            </div>
            <div class="topbar-actions">
                <a href="/nymkalgaon/admin/news/add" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i>
                    Add News
                </a>
            </div>
        </div>

        <div class="content-area">
            <!-- Flash Messages -->
            <?php 
            $flashMessage = getFlashMessage();
            if ($flashMessage): 
            ?>
                <div class="alert alert-<?php echo $flashMessage['type']; ?>">
                    <i class="fas fa-<?php echo $flashMessage['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($flashMessage['message']); ?>
                </div>
            <?php endif; ?>

            <!-- News Table -->
            <div class="table-card">
                <div class="table-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        All News Articles
                    </h2>
                    <span class="badge badge-success">
                        <?php echo $result->num_rows; ?> Articles
                    </span>
                </div>

                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Heading</th>
                                    <th>Subheading</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <img src="../../images/news/<?php echo htmlspecialchars($row['image']); ?>" 
                                                 alt="News" 
                                                 class="table-image"
                                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23ddd%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23999%22 x=%2250%%22 y=%2250%%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                                        </td>
                                        <td>
                                            <strong><?php echo formatDate($row['news_date']); ?></strong>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['heading']); ?></strong>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars(substr($row['subheading'], 0, 60)) . (strlen($row['subheading']) > 60 ? '...' : ''); ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons" style="justify-content: center;">
                                                <a href="/nymkalgaon/admin/news/edit?id=<?php echo $row['id']; ?>" 
                                                   class="btn btn-primary btn-sm btn-icon"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/nymkalgaon/admin/news/delete?id=<?php echo $row['id']; ?>" 
                                                   class="btn btn-danger btn-sm btn-icon"
                                                   title="Delete"
                                                   onclick="return confirm('Are you sure you want to delete this news article?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>No News Articles Yet</h3>
                        <p>Start by adding your first news article</p>
                        <a href="/nymkalgaon/admin/news/add" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add News
                        </a>
                    </div>
                <?php endif; ?>
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
    </script>
</body>
</html>
