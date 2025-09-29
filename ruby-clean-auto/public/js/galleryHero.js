document.addEventListener('DOMContentLoaded', () => {
  const heroSection = document.getElementById('hero-section');
  const heroBg = document.getElementById('hero-bg');
  const heroContent = document.getElementById('hero-content');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Fade in + scale
        heroBg.classList.add('opacity-100', 'scale-100');
        heroContent.classList.add('opacity-100', 'scale-100');
      } else {
        // Fade out
        heroBg.classList.remove('opacity-100', 'scale-100');
        heroContent.classList.remove('opacity-100', 'scale-100');
      }
    });
  }, {
    threshold: 0.4
  });

  if (heroSection) {
    observer.observe(heroSection);
  }
});