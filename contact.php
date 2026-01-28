<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Contact Us | Snowfall Cup</title>
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

  <!-- header -->
  <section class="hero justify-content-center" id="contact-banner">
    <div class="hero-overlay"></div>

    <div class="hero-content">
      <h1>Contact Us</h1>
      <span class="hero-tag">● <a href="index.php">Home</a> | <a href="contact.php">Contact Us</a></span>
      <p>Have questions or need support? Fill out the form below and our team will get back to you shortly.</p>
    </div>
  </section>

  <!-- ==main== -->
  <section class="contact-section">
    <div class="contact-container">

      <!-- Left Content -->
      <div class="contact-info">
        <span class="about-tag">● We’re Here to Help!</span>

        <h1>Get in Touch with<br>Our Cricket Club</h1>

        <p>
          Whether you want to join our cricket club, register for a tournament, or have a general enquiry, our team is ready to help. Reach out today and become part of a trusted local cricket club with a strong community spirit.
        </p>

        <div class="info-items">
          <div class="info-item">
            <span class="info-icon"><i class="fa-solid fa-phone"></i></span>
            <div>
              <small>Phone Number</small>
              <a href="+91-9805410601" traget="_blank">+91-9805410601</a>
            </div>
          </div>

          <div class="info-item">
            <span class="info-icon">✉</span>
            <div>
              <small>Email Address</small>
              <a href="nymkalgaon@gmail.com">nymkalgaon@gmail.com</a>
            </div>
          </div>

          <div class="info-item">
            <span class="info-icon"><i class="fa-solid fa-location-dot"></i></span>
            <div>
              <small>Location</small>
              <p>Village Kalgaon post office pujarli no 2 Tell Rohru district Shimla Himachal Pradesh 171205</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Form -->
      <div class="contact-form">
        <h3>Send Us a Message</h3>
        <p class="form-desc">
          Have questions or enquiries? Fill out the form below
        </p>

        <form action="mail2.php" method="post">
            <div class="form-grid">
                <div>
                    <label>Your Name</label>
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>

                <div>
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>

                <div>
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="Your Phone" required>
                </div>

                <div>
                    <label>City</label>
                    <input type="text" name="city" placeholder="Your City" required>
                </div>
            </div>

            <label>Message</label>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

            <button type="submit" class="mt-2">
                Send Message →
             </button>
        </form>

      </div>

    </div>
  </section>


  <!-- ==footer== -->
  <?php include 'footer.php' ?>

  <!-- js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/js/main.js"></script>

</body>

</html>