// navbar background change
window.addEventListener("scroll", () => {
    document.querySelector(".navbar-inner")
        .classList.toggle("scrolled", window.scrollY > 40);
});
