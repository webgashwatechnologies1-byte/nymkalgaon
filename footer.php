<footer class="site-footer">
  <div class="footer-container">

    <!-- Brand -->
    <div class="footer-brand">
      <div class="logo">
        <span class="logo-icon"><a href="/"><img src="./images/icons/cricket.jpeg" alt="Snowfall Cup"
              id="logo"></a></span>
      </div>
      <h4>Snowfall Cup</h4>
      <p>
        We believe local tournaments play a vital role in developing talent, building teamwork, and strengthening the
        cricket culture within the community.
      </p>
    </div>

    <!-- Quick Links -->
    <div class="footer-links">
      <h5>Quick Links</h5>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About Us</a></li>
        <li><a href="/officials">Officials</a></li>
        <li><a href="/news-letter">News & Letter</a></li>
        <li><a href="/contact">Contact Us</a></li>
      </ul>
    </div>

    <!-- other links -->
    <div class="footer-links">
      <h5>Other Links</h5>
      <ul>
        <li><a href="/privacy-policy">Privacy Policy</a></li>
        <li><a href="/terms-condition">Terms & Conditions</a></li>
      </ul>
      <h5>Follow Us On:</h5>
      <div class="socials d-flex gap-2">
        <span class="footer-social rounded">
          <a href="https://www.facebook.com/share/1DK6cuz9y9/" target="_blank"><i
              class="fa-brands fa-facebook-f"></i></a>
        </span>
        <span class="footer-social rounded">
          <a href="https://www.instagram.com/nym_kalgaon?igsh=YmRxa3lkZnA5OTR4" target="_blank"><i
              class="fa-brands fa-instagram"></i></a>
        </span>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="footer-contact">
      <h5>Contact Info</h5>

      <div class="contact-item">
        <span class="contact-icon"><i class="fa-solid fa-phone"></i></span>
        <div>
          <small><strong>Phone Number</strong></small>
          <a href="tel:+91-9805410601" traget="_blank">+91-9805410601</a>
        </div>
      </div>

      <div class="contact-item">
        <span class="contact-icon"><i class="fa-solid fa-envelope"></i></span>
        <div>
          <small><strong>Email Address</strong></small>
          <a href="mailto:nymkalgaon@gmail.com">nymkalgaon@gmail.com</a>
        </div>
      </div>

      <div class="contact-item">
        <span class="contact-icon" id="icon-location"><i class="fa-solid fa-location-dot"></i></span>
        <div>
          <small><strong>Location</strong></small>
          <p>Village Kalgaon post office pujarli no 2 Tell rohru district Shimla Himachal Pradesh 171205</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="footer-bottom">
    <div class="footer-bottom-inner">
      <div class="footer-legal">
        <p>© 2026 Snowfall Cup</p>
      </div>
      <p>All rights reserved by: <img src="./images/icons/gt-logo.gif" alt="gasgwa technologies" id="gt-logo"></p>
    </div>
  </div>
</footer>

<!-- ==popup form== -->
<!-- Join The Cup Popup -->
<div class="popup-overlay" id="joinPopup">
  <div class="popup-box">
    <button class="close-popup" id="closeJoinPopup">&times;</button>

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
          <option value="player">Player</option>
          <option value="Team Manager">Team Manager</option>
          <option value="Sponsor">Sponsor</option>
          <option value="Volunteer">Volunteer</option>
        </select>
      </div>

      <div class="form-group">
        <textarea placeholder="Message (Optional)"></textarea>
      </div>

      <button type="submit" class="submit-btn">
        Submit Registration <span><i class="fa-solid fa-paper-plane"></i></span>
      </button>
    </form>
  </div>
</div>

<!-- popup form -->
<script>
  const openBtn = document.getElementById("openJoinPopup");
  const closeBtn = document.getElementById("closeJoinPopup");
  const popup = document.getElementById("joinPopup");

  openBtn.addEventListener("click", function (e) {
    e.preventDefault();
    popup.classList.add("active");
  });

  closeBtn.addEventListener("click", function () {
    popup.classList.remove("active");
  });

  popup.addEventListener("click", function (e) {
    if (e.target === popup) {
      popup.classList.remove("active");
    }
  });
</script>