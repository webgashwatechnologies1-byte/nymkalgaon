<!DOCTYPE html>
<html lang="en">
<?php
// Include database connection
require_once __DIR__ . '/backend/config.php';

// Fetch featured content
$featuredQuery = $conn->query("SELECT * FROM featured WHERE id = 1 LIMIT 1");
$featured = $featuredQuery->num_rows > 0 ? $featuredQuery->fetch_assoc() : null;

// Fetch all news articles (latest first)
$newsQuery = $conn->query("SELECT * FROM news ORDER BY news_date DESC, created_at DESC");
$newsArticles = [];
while ($row = $newsQuery->fetch_assoc()) {
    $newsArticles[] = $row;
}
?>
<head>
    <meta charset="UTF-8">
    <title>News & Updates | Snowfall Cup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- favicon -->
    <link rel="icon" href="./images/icons/cricket.jpeg">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/other.css">
</head>
<style>
    /* Banner */
    .page-banner {
        padding: 100px 6%;
        text-align: center;
        background: linear-gradient(135deg, #000, #1a1a1a);
        color: #fff;
    }

    .page-banner h1 {
        font-size: 48px;
        font-weight: 800;
    }

    /* Featured */
    .featured-news {
        padding: 80px 6%;
    }

    .featured-card {
        max-width: 1300px;
        margin: auto;
        display: flex;
        gap: 40px;
        background: #f3f4f6;
        padding: 50px;
        border-radius: 28px;
    }

    .featured-card img {
        width: 100%;
        max-width: 45%;
        border-radius: 22px;
        object-fit: cover;
    }

    .feature-inner {
        align-content: center;
    }

    .full-details {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: all 0.4s ease;
        margin-top: 0;
    }

    .full-details.active {
        max-height: 500px;
        opacity: 1;
        margin-top: 15px;
    }

    .read-more-btn {
        display: inline-block;
        margin-top: 10px;
        color: #dfb441;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .read-more-btn:hover {
        text-decoration: underline;
    }


    .tag {
        background: #dfb441;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 13px;
    }

    /* News Grid */
    .news-section {
        padding: 80px 6%;
        background: #fafafa;
    }

    .news-grid {
        max-width: 1300px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .news-content {
        padding: 13px;
    }

    .date-tag {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #dfb441;
        color: #000;
        font-weight: 700;
        font-size: 13px;
        padding: 8px 14px;
        border-radius: 30px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    }

    .update-social
    {
        background: #dfb441;
    border: 1px solid #dfb441;
    padding: 5px;
    width: 45px;
    text-align: center;
    transition: transform 0.5s;

    }

    .update-social:hover{
        transform: rotateY(180deg);
    }

    .update-social a{
        color: black;
    }

    /* Responsive */
    @media(max-width: 900px) {
        .featured-card {
            flex-direction: column;
        }

        .featured-card img {
            width: 100%;
        }

        .news-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<body>
    <!-- header -->
    <?php include 'header.php' ?>

    <!-- Hero section -->
    <section class="hero justify-content-center" id="news-banner">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1>News & Letters</h1>
            <span class="hero-tag">● <a href="/">Home</a> | <a href="/news-letter">News & Letter</a></span>
            <p>
                Stay updated with the Latest updates, announcements & official communication.
            </p>
        </div>
    </section>

    <!-- ================= FEATURED NEWS ================= -->
    <section class="featured-news">
        <?php if ($featured): ?>
        <div class="featured-card">
            <div class="feature-inner">
                <span class="about-tag">● <?php echo htmlspecialchars($featured['dotext']); ?></span>
                <h2 class="about-title"><?php echo htmlspecialchars($featured['heading']); ?></h2>

                <p>
                    <?php echo htmlspecialchars($featured['subheading']); ?>
                </p>

                <!-- Toggle Button -->
                <a href="javascript:void(0)" class="read-more-btn" onclick="toggleDetails(this)">
                    Read Full Update →
                </a>

                <!-- Hidden Content -->
                <p class="full-details">
                    <?php echo nl2br(htmlspecialchars($featured['details'])); ?>
                </p>
            </div>

            <img src="./backend/images/featured/<?php echo htmlspecialchars($featured['image']); ?>" alt="<?php echo htmlspecialchars($featured['heading']); ?>">
        </div>
        <?php else: ?>
        <div class="featured-card">
            <div class="feature-inner">
                <span class="about-tag">● Featured</span>
                <h2 class="about-title">No Featured Content Available</h2>
                <p>Check back soon for updates!</p>
            </div>
            <img src="./images/about/new-letter.jpg" alt="Placeholder">
        </div>
        <?php endif; ?>
    </section>

    <!-- ================= NEWS GRID ================= -->
    <section class="news-section">
        <div class="container d-flex justify-content-center">
            <div class="news-div">
                <span class="about-tag">● Update</span>
                <h3 class="section-title">Latest News</h3>

                <div class="news-grid">
                    <?php if (count($newsArticles) > 0): ?>
                        <?php foreach ($newsArticles as $news): ?>
                        <!-- News Card -->
                        <div class="news-card">
                            <div class="news-image">
                                <img src="./backend/images/news/<?php echo htmlspecialchars($news['image']); ?>" alt="<?php echo htmlspecialchars($news['heading']); ?>">
                                <span class="date-tag"><?php echo date('d M Y', strtotime($news['news_date'])); ?></span>
                            </div>
                            <div class="news-content">
                                <h4><?php echo htmlspecialchars($news['heading']); ?></h4>
                                <summary>
                                    <p><?php echo htmlspecialchars($news['subheading']); ?></p>
                                </summary>
                                <details>
                                    <p><?php echo nl2br(htmlspecialchars($news['details'])); ?></p>
                                </details>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No News Available -->
                        <div class="news-card">
                            <div class="news-content">
                                <h4>No News Available</h4>
                                <p>Check back soon for the latest updates!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="updation py-5">
        <div class="container d-flex justify-content-center">
            <div class="div-updated">
                <span class="about-tag">● Update</span>
                <h3 class="section-title">Stay Connected</h2>
                <p>Stay connected with our social media channels to receive the latest Snowfall Cup news & announcements.</p>
                <div class="socials d-flex gap-2">
                    <span class="about-tag mb-0">Follow Us On</span> 
                    <span class="update-social rounded">
                        <a href="https://www.facebook.com/share/1DK6cuz9y9/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    </span>
                    <span class="update-social rounded">
                        <a href="https://www.instagram.com/nym_kalgaon?igsh=YmRxa3lkZnA5OTR4" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==footer== -->
    <?php include 'footer.php' ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
    <script>
        function toggleDetails(btn) {
            const details = btn.nextElementSibling;

            details.classList.toggle('active');

            if (details.classList.contains('active')) {
                btn.textContent = 'Hide Details ←';
            } else {
                btn.textContent = 'Read Full Update →';
            }
        }
    </script>


</body>

</html>