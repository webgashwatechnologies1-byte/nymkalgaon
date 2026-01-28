<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Snowfall Cup</title>
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

<body>
    <!-- header -->
    <?php include 'header.php' ?>

    <!-- ==hero-section== -->
    <section class="hero-section hero-animate">
        <div class="hero-overlay"></div>

        <div class="container hero-banner-content">
            <div class="row align-items-center justify-content-center">

                <!-- LEFT SIDE -->
                <div class="col-md-7 text-white">
                    <span class="hero-tag">Snowfall Cup & Community</span>

                    <h1 class="hero-title">
                        Join the Future of <br>
                        <span>Cricket Club</span>
                    </h1>

                    <!-- Members Card -->
                    <div class="members-card d-flex align-items-center gap-3 mt-4">
                        <img src="https://via.placeholder.com/70" class="rounded-3" alt="">
                        <div>
                            <h5 class="mb-0 text-success">5+</h5>
                            <small>nym Kalgaon. An Organination </small>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-4 mt-5 mt-lg-0">
                    <div class="info-box text-white">
                        <h3>Join Snowfall Cup</h3>
                        <p>Register your interest and be part of upcoming local cricket tournaments.</p>

                        <form class="popup-form" action="mail.php" method="post">

    <div class="form-group">
        <input type="text" name="name" placeholder="Name" required>
    </div>

    <div class="form-group">
        <input type="email" name="email" placeholder="Email Address" required>
    </div>

    <div class="form-group">
        <input type="tel" name="phone" placeholder="Phone Number" required>
    </div>

    <div class="form-group">
        <select name="role" required>
            <option value="">Select Role</option>
            <option>Player</option>
            <option>Team Manager</option>
            <option>Sponsor</option>
            <option>Volunteer</option>
        </select>
    </div>

    <div class="form-group">
        <textarea name="message" placeholder="Message (Optional)"></textarea>
    </div>

    <!-- REQUIRED for PHP check -->
    <button type="submit" name="popup_submit" class="submit-btn">
        Submit Registration <span><i class="fa-solid fa-paper-plane"></i></span>
    </button>

</form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==about-us section== -->
    <section class="space about-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- LEFT Content -->
                <div class="col-lg-7">
                    <span class="about-tag">● About Us</span>

                    <h2 class="about-title">
                        More Than Just a <br>
                        Snowfall Cup, It's a <br>
                        <span>Community.</span>
                    </h2>

                    <p class="about-text">
                        We are proud organizers of the <strong>Snowfall Cup</strong>, a thrilling cricket tournament that brings together
                        passionate players and cricket enthusiasts in a spirit of sportsmanship and competition. In addition
                        to promoting cricket, our <strong>Nature Club</strong> focuses on fostering a connection with the environment through
                        various activities that celebrate and preserve the beauty of nature. Join us to experience the excitement 
                        of cricket and the serenity of nature, all in one place! Get in touch with us for tournament updates, 
                        registrations, and club memberships.
                    </p>

                    <p class="about-text">
                        From grassroots training to professional-level matches and leagues,
                        our club is built for players who want to improve their skills,
                        stay active, and be part of something bigger than the game.
                    </p>

                    <!-- STATS -->
                    <div class="d-flex gap-3 about-stats">
                        <span>
                            <a href="/about" class="btn in-touch">
                                View More <span class="arrow"><i class="fa-solid fa-paper-plane"></i></span>
                            </a>
                        </span>
                        <span>
                            <a href="/contact" class="btn in-touch">
                                Get In Touch <span class="arrow"><i class="fa-solid fa-paper-plane"></i></span>
                            </a>
                        </span>
                        </a>
                    </div>
                </div>

                <!-- Right Image Card -->
                <div class="col-lg-5">
                    <div class="about-image-card">
                        <img src="./images/about/about-image-1.jpg" alt="Snowfall Cup">

                        <div class="about-highlight">
                            <span>
                                Snowfall Cup organises local cricket tournaments, bringing players and teams
                                together through competitive and well-managed matches.
                            </span>
                            <a href="/about" class="about-link">
                                Learn More <span><i class="fa-solid fa-paper-plane"></i></span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==community section== -->
    <section class="community-section">
        <div class="community-container">

            <!-- Left Image Card -->
            <div class="image-card">
                <img src="./images/about/about-image-3.jpg" alt="Padel equipment on court" />
                <div class="image-cta">
                    <h4>Be Part of<br>Something Bigger<br>Than the Game</h4>
                    <span class="cta-link">Join The Community →</span>
                </div>
            </div>

            <!-- Right Content -->
            <div class="content">
                <span class="about-tag">● Community</span>
                <h2 class="about-title">nym Kalgaon <span>Community</span></h2>
                <p>Join nym Kalgaon and grow with a passionate local cricket community through organised
                    tournaments.</p>

                <div class="features">
                    <div class="feature">
                        <div class="icon"><img src="./images/icons/time.png" alt="clock"></div>
                        <div>
                            <h4>Regular Local Matches</h4>
                            <p>Friendly and competitive local matches held regularly to keep players active and
                                strengthen team spirit.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="icon"><img src="./images/icons/skill.png" alt="skill"></div>
                        <div>
                            <h4>Team & Skill-Based Competitions</h4>
                            <p>Play in well-matched groups and tournaments designed for teams and players of similar
                                skill levels.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="icon"><img src="./images/icons/member.png" alt="member"></div>
                        <div>
                            <h4>Member Only Events</h4>
                            <p>Exclusive workshops, networking nights, and closed tournaments for members.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ==team member== -->
    <section class="team-section">
        <div class="container">
            <div class="team-header">
                <span class="about-tag">● Our Team</span>

                <div class="team-title">
                    <h3 class="about-title"><span>Meet the Team</span> Behind <br> nym Kalgaon</h3>
                    <a href="/officials" class="view-all-btn">
                        View All Members
                        <span><i class="fa-solid fa-paper-plane"></i></span>
                    </a>
                </div>

                <div class="divider"></div>
            </div>


            <div class="team-wrapper">
                <div class="team-track">

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/member-4.jpeg" alt="Chairman">
                            <div class="card-content">
                                <div>
                                    <h4>Jeshu Chauhan</h4>
                                    <span>Chairman</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-9805177400"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/pawan-dutta.jpeg" alt="Vice Chairman">
                            <div class="card-content">
                                <div>
                                    <h4>Pawan Dutta</h4>
                                    <span>Vice Chairman</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-9857621000"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/member-5.jpeg" alt="President">
                            <div class="card-content">
                                <div>
                                    <h4>Mohit Dutta</h4>
                                    <span>President</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-9805610601"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/vineet-dutta.jpeg" alt="Vice President">
                            <div class="card-content">
                                <div>
                                    <h4>Vineet Dutta</h4>
                                    <span>Vice President</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-9015180105"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/member-1.jpeg" alt="General Secretary">
                            <div class="card-content">
                                <div>
                                    <h4>Harish Karrow</h4>
                                    <span>General Secretary</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-8219555417"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="team-slide">
                        <div class="team-card">
                            <img src="./images/about/member-2.jpeg" alt="Secretary">
                            <div class="card-content">
                                <div>
                                    <h4>Shubham Dutta</h4>
                                    <span>Secretary</span>
                                </div>
                                <span class="team-arrow">
                                    <a href="tel:+91-8894848900"><i class="fa-solid fa-phone"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- ===== Why Choose Us ===== -->
    <section class="space why-choose-section py-5">
        <div class="container">
            <div class="row align-items-center g-5 justify-content-center">

                <!-- LEFT CONTENT -->
                <div class="col-lg-6">
                    <span class="about-tag">● Why Choose Us</span>

                    <h3 class="about-title">
                        Why Cricket Players Choose<br>
                        <span>Snowfall Cup.</span>
                    </h3>

                    <p class="section-text">
                        Why Snowfall Cup Is a Trusted Name in Local Cricket Tournaments
                    </p>
                </div>

                <!-- RIGHT FEATURES -->
                <div class="col-lg-12">
                    <div class="row g-4 why-grid">

                        <div class="col-md-3">
                            <div class="why-card premium">
                                <div class="icon-box"><i class="fa-solid fa-baseball"></i></div>
                                <h5>Professionally Organised Tournaments</h5>
                                <p>We organise well-planned local cricket tournaments with clear schedules and smooth
                                    match management.</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="why-card premium dark active">
                                <div class="icon-box"><i class="fa-solid fa-bullseye"></i></div>
                                <h5>Fair Play & Certified Umpires</h5>
                                <p>Our matches are officiated with fairness and transparency, ensuring every game is
                                    played in the true spirit of cricket.</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="why-card premium">
                                <div class="icon-box"><i class="fa-solid fa-trophy"></i></div>
                                <h5>Quality Grounds & Facilities</h5>
                                <p>We use quality local cricket grounds that provide safe pitches and professional
                                    playing conditions.</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="why-card premium">
                                <div class="icon-box"><i class="fa-solid fa-house-circle-check"></i></div>
                                <h5>Strong Local Cricket Community</h5>
                                <p>We connects teams and players by organising competitive local cricket tournaments
                                    that support community cricket.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- testimonial -->
    <?php include 'testimonial.php' ?>

    <!-- footer -->
    <?php include 'footer.php' ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- hero-slider -->
    <script>
        const heroSection = document.querySelector('.hero-section');

        const heroImages = [
            './images/banner/hero-banner.jpg',
            './images/banner/hero-banner-2.jpg',
            './images/banner/hero-banner-3.jpg'
        ];

        let currentIndex = 0;

        function changeHeroBackground() {
            currentIndex = (currentIndex + 1) % heroImages.length;

            // Remove animation class to restart animation
            heroSection.classList.remove('hero-animate');

            // Change background
            heroSection.style.backgroundImage = `url(${heroImages[currentIndex]})`;

            // Trigger reflow to restart animation
            void heroSection.offsetWidth;

            // Add animation class
            heroSection.classList.add('hero-animate');
        }

        // Initial background
        heroSection.style.backgroundImage = `url(${heroImages[0]})`;
        heroSection.classList.add('hero-animate');

        // Auto slide every 2 seconds
        setInterval(changeHeroBackground, 3000);
    </script>

    <!-- ==official slider== -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const track = document.querySelector(".team-track");
            const slides = document.querySelectorAll(".team-slide");
            let index = 0;

            function getVisibleSlides() {
                if (window.innerWidth <= 768) return 1;
                if (window.innerWidth <= 1024) return 3;
                return 4;
            }

            function slideTeam() {
                const visible = getVisibleSlides();
                index++;

                if (index > slides.length - visible) {
                    index = 0;
                }

                const slideWidth = slides[0].offsetWidth;
                track.style.transform = `translateX(-${index * slideWidth}px)`;
            }

            setInterval(slideTeam, 3000);
        });
    </script>
    <script src="/js/main.js"></script>

</body>

</html>