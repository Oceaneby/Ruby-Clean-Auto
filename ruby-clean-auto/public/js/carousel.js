 const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('#carousel-dots button');
  let currentIndex = 0;

  const showSlide = index => {
    slides.forEach((slide, i) => {
      slide.classList.toggle('hidden', i !== index);
    });
    dots.forEach((dot, i) => {
      if(i === index) {
        dot.classList.remove('bg-gray-400');
        dot.classList.add('bg-red-500');
      } else {
        dot.classList.remove('bg-red-500');
        dot.classList.add('bg-gray-400');
      }
    });
  };

  // Initial display
  showSlide(currentIndex);

  // Click on dots
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      currentIndex = i;
      showSlide(currentIndex);
    });
  });

  // Auto-play every 5s
  setInterval(() => {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }, 15000);