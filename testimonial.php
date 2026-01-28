<section class="testimonial-section">
  <span class="about-tag">● Testimonials</span>
  <h3 class="about-title">What Our Members Say</h3>

  <div class="testimonial-slider">
    <button class="nav-btn prev">&#10094;</button>

    <div class="testimonial-track">

      <!-- Card 1 -->
      <div class="testimonial-card">
        <p>
          “Snowfall Cup is an incredible initiative. The atmosphere, organization,
          and snow cricket experience are truly unforgettable.”
        </p>
        <div class="user">
          <img src="./images/icons/client.png" alt="client">
          <div>
            <h4>Rohit Sharma</h4>
            <span>Team Captain</span>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="testimonial-card">
        <p>
          “Well-managed tournament with great facilities. Playing cricket on snow
          was a once-in-a-lifetime experience!”
        </p>
        <div class="user">
          <img src="./images/icons/client.png" alt="client">
          <div>
            <h4>Ankit Verma</h4>
            <span>All-Rounder</span>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="testimonial-card">
        <p>
          “Amazing crowd, amazing teams, and top-class management.
          Snowfall Cup keeps getting better every year.”
        </p>
        <div class="user">
          <img src="./images/icons/client.png" alt="client">
          <div>
            <h4>Pooja Thakur</h4>
            <span>Event Volunteer</span>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="testimonial-card">
        <p>
          “From hospitality to ground arrangements, everything was spot on.
          Proud to be part of Snowfall Cup.”
        </p>
        <div class="user">
          <img src="./images/icons/client.png" alt="client">
          <div>
            <h4>Vikas Negi</h4>
            <span>Club Member</span>
          </div>
        </div>
      </div>

    </div>

    <button class="nav-btn next">&#10095;</button>
  </div>
</section>
<script>
const track = document.querySelector('.testimonial-track');
const slides = document.querySelectorAll('.testimonial-card');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let index = 0;

function updateSlider() {
    track.style.transform = `translateX(-${index * 100}%)`;
}

nextBtn.addEventListener('click', () => {
    index = (index + 1) % slides.length;
    updateSlider();
});

prevBtn.addEventListener('click', () => {
    index = (index - 1 + slides.length) % slides.length;
    updateSlider();
});

/* Auto Slide */
setInterval(() => {
    index = (index + 1) % slides.length;
    updateSlider();
}, 5000);
</script>

