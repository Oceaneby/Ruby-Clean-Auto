const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      const el = entry.target;
      const delay = parseInt(el.dataset.delay) || 0;

      if (entry.isIntersecting) {
        setTimeout(() => {
          el.classList.add('animate-slide-in-right');
          el.classList.remove('opacity-0', 'translate-x-10');
        }, delay);
      } else {
        // Effet réversible
        el.classList.remove('animate-slide-in-right');
        el.classList.add('opacity-0', 'translate-x-10');
      }
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.service-card').forEach(el => observer.observe(el));