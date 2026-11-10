/**
 * Market Theme — Lightweight Native Slider & Carousel Module
 */

export function initSliders() {
  initHeroSlider();
  initProductCarousels();
  initCategoriesCarousel();
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

/**
 * 3. Circular Categories Auto-scrolling Carousel (3 items per view)
 */
function initCategoriesCarousel() {
  const container = document.getElementById('categoriesCircleCarousel');
  if (!container) return;

  const track = container.querySelector('.categories-carousel-track');
  const slides = container.querySelectorAll('.category-carousel-slide');
  const prevBtn = container.querySelector('.categories-nav-prev');
  const nextBtn = container.querySelector('.categories-nav-next');
  const dots = container.querySelectorAll('.categories-dot');

  if (!track || !slides.length) return;

  const totalSlides = slides.length;
  const visibleCount = 3;

  if (totalSlides <= visibleCount) {
    track.style.justifyContent = 'center';
    return;
  }

  const maxIndex = totalSlides - visibleCount;
  let currentIndex = 0;
  let autoplayTimer = null;
  const interval = parseInt(container.dataset.autoplayInterval, 10) || 3500;

  const isRtl = document.documentElement.dir === 'rtl' ||
                document.body.classList.contains('rtl') ||
                (window.getComputedStyle(document.body).direction === 'rtl');

  function getStepDistance() {
    if (slides.length < 2) return 0;
    const rect0 = slides[0].getBoundingClientRect();
    const rect1 = slides[1].getBoundingClientRect();
    return Math.abs(rect1.left - rect0.left);
  }

  function updateCarousel(index) {
    if (index < 0) {
      currentIndex = maxIndex;
    } else if (index > maxIndex) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }

    const stepDistance = getStepDistance();
    // In RTL, moving to later slides shifts the track positively in X
    const offset = (isRtl ? 1 : -1) * (currentIndex * stepDistance);
    track.style.transform = `translateX(${offset}px)`;

    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentIndex);
    });
  }

  function nextSlide() {
    updateCarousel(currentIndex + 1);
  }

  function prevSlide() {
    updateCarousel(currentIndex - 1);
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      nextSlide();
      resetAutoplay();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      prevSlide();
      resetAutoplay();
    });
  }

  dots.forEach((dot) => {
    dot.addEventListener('click', (e) => {
      e.preventDefault();
      const targetIdx = parseInt(dot.dataset.slideIndex, 10) || 0;
      updateCarousel(targetIdx);
      resetAutoplay();
    });
  });

  function startAutoplay() {
    if (autoplayTimer) clearInterval(autoplayTimer);
    autoplayTimer = setInterval(nextSlide, interval);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  container.addEventListener('mouseenter', stopAutoplay);
  container.addEventListener('mouseleave', startAutoplay);

  // Touch Swipe for Mobile Devices
  let touchStartX = 0;
  let touchEndX = 0;

  container.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    stopAutoplay();
  }, { passive: true });

  container.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > 40) {
      if (diff < 0) {
        // Swiped left -> advance next
        nextSlide();
      } else {
        // Swiped right -> go prev
        prevSlide();
      }
      resetAutoplay();
    } else {
      startAutoplay();
    }
  }, { passive: true });

  // Handle window resizing without transition lag
  let resizeTimer = null;
  window.addEventListener('resize', () => {
    track.style.transition = 'none';
    updateCarousel(currentIndex);
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      track.style.transition = '';
    }, 150);
  });

  // Start initial autoplay
  startAutoplay();
}

