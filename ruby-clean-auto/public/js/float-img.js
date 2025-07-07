document.addEventListener('DOMContentLoaded', () => {
    const image = document.getElementById('float-img');
    const section = document.getElementById('section-text');

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          image.classList.remove('opacity-0', 'translate-x-[-100px]');
          image.classList.add('opacity-100', 'translate-x-0');
        } else {
          image.classList.remove('opacity-100', 'translate-x-0');
          image.classList.add('opacity-0', 'translate-x-[-100px]');
        }
      });
    }, {
      threshold: 0.5
    });

    observer.observe(section);
  });