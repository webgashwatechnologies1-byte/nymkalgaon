<?php
// Shared Admin Layout Functions
// Include this at the top of admin pages

function renderAdminHeader($title, $activeMenu = '') {
    global $user;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($title); ?> - NYM Kalgaon Admin</title>
        <link rel="icon" href="../../../images/icons/cricket.jpeg">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="<?php echo getAdminAssetPath('admin.css'); ?>">
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
                    <a href="/nymkalgaon/admin/dashboard" class="nav-link <?php echo $activeMenu === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/nymkalgaon/admin/news" class="nav-link <?php echo $activeMenu === 'news' ? 'active' : ''; ?>">
                        <i class="fas fa-newspaper"></i>
                        <span>Manage News</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/nymkalgaon/admin/featured" class="nav-link <?php echo $activeMenu === 'featured' ? 'active' : ''; ?>">
                        <i class="fas fa-star"></i>
                        <span>Featured Content</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/nymkalgaon/admin/users/register" class="nav-link <?php echo $activeMenu === 'users' ? 'active' : ''; ?>">
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
    <?php
}

function renderTopbar($pageTitle, $icon = 'fa-home', $backLink = null) {
    ?>
    <div class="topbar">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1>
                <i class="fas <?php echo $icon; ?>" style="color: var(--primary);"></i>
                <?php echo htmlspecialchars($pageTitle); ?>
            </h1>
        </div>
        <div class="topbar-actions">
            <?php if ($backLink): ?>
                <a href="<?php echo $backLink; ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            <?php endif; ?>
            <a href="/nymkalgaon" class="btn btn-outline btn-sm">
                <i class="fas fa-globe"></i>
                <span class="hide-mobile">View Site</span>
            </a>
        </div>
    </div>
    <div class="content-area">
    <?php
}

function renderFlashMessage() {
    $flashMessage = getFlashMessage();
    if ($flashMessage): 
    ?>
        <div class="alert alert-<?php echo $flashMessage['type']; ?>">
            <i class="fas fa-<?php echo $flashMessage['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo htmlspecialchars($flashMessage['message']); ?>
        </div>
    <?php 
    endif;
}

function renderAdminFooter() {
    ?>
        </div> <!-- content-area -->
    </main> <!-- main-content -->

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

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
    <?php
}

function getAdminAssetPath($file) {
    // Determine the correct path based on current directory depth
    $depth = substr_count($_SERVER['PHP_SELF'], '/') - substr_count('/nymkalgaon/', '/');
    $prefix = str_repeat('../', max(0, $depth - 3));
    return $prefix . 'assets/' . $file;
}
?>
