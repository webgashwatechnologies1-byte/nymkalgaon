<?php
if (!defined('BACKEND_ROOT')) {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../helpers.php';
}

// Require login
requireLogin();

// Get current user
$user = getCurrentUser();

// Get statistics
$newsCount = $conn->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'];
$featuredExists = $conn->query("SELECT COUNT(*) as count FROM featured WHERE id = 1")->fetch_assoc()['count'] > 0;
$usersCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

// Get recent news
$recentNews = $conn->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NYM Kalgaon Admin</title>
    <link rel="icon" href="../../images/icons/cricket.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1f2937;
            --light: #f9fafb;
            --border: #e5e7eb;
            --text: #374151;
            --text-light: #6b7280;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--light);
            color: var(--text);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 15px;
        }

        .sidebar-header h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 4px solid white;
        }

        .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 18px;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-details h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
            background: var(--primary);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .topbar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-card h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
        }

        .welcome-card p {
            font-size: 16px;
            opacity: 0.95;
            position: relative;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .stat-card.success::before { background: var(--success); }
        .stat-card.warning::before { background: var(--warning); }
        .stat-card.info::before { background: var(--info); }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
        .stat-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

        .stat-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .quick-actions h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            padding: 20px;
            border-radius: 12px;
            border: 2px solid var(--border);
            background: white;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .action-btn:hover {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .action-btn i {
            font-size: 24px;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .recent-activity h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .activity-item {
            padding: 15px;
            border-left: 3px solid var(--primary);
            background: var(--light);
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: #f3f4f6;
            transform: translateX(5px);
        }

        .activity-item h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .activity-item p {
            font-size: 13px;
            color: var(--text-light);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 15px 20px;
            }

            .topbar h1 {
                font-size: 22px;
            }

            .content-area {
                padding: 20px;
            }

            .welcome-card {
                padding: 30px 20px;
            }

            .welcome-card h2 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .topbar-actions {
                gap: 8px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 13px;
            }
        }

        /* Overlay for mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="../../images/icons/cricket.jpeg" alt="NYM Kalgaon">
            <h3>NYM Kalgaon</h3>
        </div>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="/nymkalgaon/admin/dashboard" class="nav-link active">
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
                    <i class="fas fa-chart-line" style="color: var(--primary);"></i>
                    Dashboard
                </h1>
            </div>
            <div class="topbar-actions">
                <a href="/nymkalgaon" class="btn btn-outline">
                    <i class="fas fa-globe"></i>
                    <span class="hide-mobile">View Site</span>
                </a>
            </div>
        </div>

        <div class="content-area">
            <!-- Welcome Card -->
            <div class="welcome-card">
                <h2>👋 Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <p>Here's what's happening with your website today</p>
            </div>

            <!-- Flash Messages -->
            <?php 
            $flashMessage = getFlashMessage();
            if ($flashMessage): 
            ?>
                <div class="alert alert-<?php echo $flashMessage['type']; ?>" style="margin-bottom: 30px; padding: 15px 20px; border-radius: 12px; background: #d1fae5; color: #065f46; border-left: 4px solid #10b981;">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($flashMessage['message']); ?>
                </div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value"><?php echo $newsCount; ?></div>
                            <div class="stat-label">Total News Articles</div>
                        </div>
                        <div class="stat-icon primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value"><?php echo $featuredExists ? '1' : '0'; ?></div>
                            <div class="stat-label">Featured Content</div>
                        </div>
                        <div class="stat-icon success">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card info">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value"><?php echo $usersCount; ?></div>
                            <div class="stat-label">Admin Users</div>
                        </div>
                        <div class="stat-icon info">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value"><i class="fas fa-check-circle" style="font-size: 28px; color: var(--success);"></i></div>
                            <div class="stat-label">System Status</div>
                        </div>
                        <div class="stat-icon warning">
                            <i class="fas fa-server"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3>
                    <i class="fas fa-bolt" style="color: var(--warning);"></i>
                    Quick Actions
                </h3>
                <div class="actions-grid">
                    <a href="/nymkalgaon/admin/news/add" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New News
                    </a>
                    <a href="/nymkalgaon/admin/featured" class="action-btn">
                        <i class="fas fa-star"></i>
                        Update Featured
                    </a>
                    <a href="/nymkalgaon/admin/users/register" class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        Add New User
                    </a>
                    <a href="/nymkalgaon/admin/news" class="action-btn">
                        <i class="fas fa-list"></i>
                        View All News
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <h3>
                    <i class="fas fa-clock" style="color: var(--info);"></i>
                    Recent News Articles
                </h3>
                <?php if ($recentNews->num_rows > 0): ?>
                    <?php while ($news = $recentNews->fetch_assoc()): ?>
                        <div class="activity-item">
                            <h4><?php echo htmlspecialchars($news['heading']); ?></h4>
                            <p>
                                <i class="fas fa-calendar"></i>
                                <?php echo formatDate($news['news_date']); ?> • 
                                <i class="fas fa-clock"></i>
                                <?php echo formatDate($news['created_at'], 'd M Y, H:i'); ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <p>No news articles yet. Create your first one!</p>
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
