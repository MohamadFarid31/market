/**
 * Market Theme — Lightweight Native Slider & Carousel Module
 */

export function initSliders() {
  initHeroSlider();
  initProductCarousels();
}

/**
 * 1. Hero Banner Slider
 */
function initHeroSlider() {
  const container = document.getElementById('heroSlider');
  if (!container) return;

  const slides = container.querySelectorAll('.hero-slide');
  const dots = container.querySelectorAll('.hero-dot');
  const prevBtn = container.querySelector('.hero-arrow-prev');
  const nextBtn = container.querySelector('.hero-arrow-next');

  if (slides.length <= 1) return;

  let currentIndex = 0;
  let autoplayTimer = null;

  function showSlide(index) {
    if (index < 0) {
      currentIndex = slides.length - 1;
    } else if (index >= slides.length) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }

    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === currentIndex);
    });

    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === currentIndex);
    });
  }

  function nextSlide() {
    showSlide(currentIndex + 1);
  }

  function prevSlide() {
    showSlide(currentIndex - 1);
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      resetAutoplay();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      resetAutoplay();
    });
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      showSlide(i);
      resetAutoplay();
    });
  });

  function startAutoplay() {
    autoplayTimer = setInterval(nextSlide, 5000);
  }

  function resetAutoplay() {
    if (autoplayTimer) clearInterval(autoplayTimer);
    startAutoplay();
  }

  container.addEventListener('mouseenter', () => {
    if (autoplayTimer) clearInterval(autoplayTimer);
  });

  container.addEventListener('mouseleave', () => {
    startAutoplay();
  });

  // Touch Swipe for Mobile Hero Slider
  let touchStartX = 0;
  let touchEndX = 0;

  container.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  container.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }, { passive: true });

  function handleSwipe() {
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > 40) {
      if (diff > 0) {
        // Swiped Right
        nextSlide();
      } else {
        // Swiped Left
        prevSlide();
      }
      resetAutoplay();
    }
  }

  startAutoplay();
}

/**
 * 2. Product Carousels Active Dot Tracker
 */
function initProductCarousels() {
  const tracks = document.querySelectorAll('.product-carousel-track');
  tracks.forEach((track) => {
    const parentWrap = track.closest('.product-carousel-wrap');
    if (!parentWrap) return;

    const dots = parentWrap.querySelectorAll('.carousel-dot');
    if (!dots.length) return;

    track.addEventListener('scroll', () => {
      const scrollPos = track.scrollLeft;
      const totalScrollable = track.scrollWidth - track.clientWidth;
      if (totalScrollable <= 0) return;

      const progress = Math.abs(scrollPos) / totalScrollable;
      const activeIndex = Math.min(
        dots.length - 1,
        Math.floor(progress * dots.length)
      );

      dots.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === activeIndex);
      });
    }, { passive: true });
  });

  // Focus mobile search input when clicking the bottom bar search item
  const bottomSearchTrigger = document.getElementById('mobile-bottom-search-trigger');
  if (bottomSearchTrigger) {
    bottomSearchTrigger.addEventListener('click', (e) => {
      e.preventDefault();
      const mobileSearchInput = document.getElementById('mobile-search-field');
      if (mobileSearchInput) {
        mobileSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => mobileSearchInput.focus(), 300);
      }
    });
  }
}

