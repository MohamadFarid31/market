/**
 * Market Theme — Lightweight Native Slider & Carousel Module
 */

export function initSliders() {
  initHeroSlider();
  initProductCarousels();
  initCategoriesCarousel();
}

/**
 * 1. Hero Banner Slider (Smooth Hardware-Accelerated Sliding with Infinite Loop)
 */
function initHeroSlider() {
  const container = document.getElementById('heroSlider');
  if (!container) return;

  let track = container.querySelector('.hero-slider-track');
  const slides = Array.from(container.querySelectorAll('.hero-slide'));
  const dots = Array.from(container.querySelectorAll('.hero-dot'));
  const prevBtn = container.querySelector('.hero-arrow-prev');
  const nextBtn = container.querySelector('.hero-arrow-next');

  if (slides.length <= 1) return;

  // Ensure track exists in case of legacy markup
  if (!track) {
    track = document.createElement('div');
    track.className = 'hero-slider-track';
    slides.forEach((slide) => track.appendChild(slide));
    container.insertBefore(track, container.firstChild);
  }

  const isRtl =
    (window.marketData && typeof window.marketData.isRtl === 'boolean')
      ? window.marketData.isRtl
      : document.documentElement.dir === 'rtl' ||
        document.body.classList.contains('rtl') ||
        window.getComputedStyle(document.body).direction === 'rtl';

  // In RTL flex layout, slides flow right-to-left. Shifting track positively (+X) reveals the next slide.
  const dirMult = isRtl ? 1 : -1;

  // Infinite seamless clones (prepend clone of last, append clone of first)
  const firstClone = slides[0].cloneNode(true);
  const lastClone = slides[slides.length - 1].cloneNode(true);

  firstClone.classList.add('hero-slide-clone');
  lastClone.classList.add('hero-slide-clone');
  firstClone.classList.remove('active');
  lastClone.classList.remove('active');

  // Strip IDs from clones to avoid duplicate DOM IDs
  firstClone.removeAttribute('id');
  lastClone.removeAttribute('id');
  firstClone.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));
  lastClone.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));

  track.appendChild(firstClone);
  track.insertBefore(lastClone, slides[0]);

  const allSlides = Array.from(track.querySelectorAll('.hero-slide'));
  let currentTrackIndex = 1; // Index 1 is the original first slide
  let isTransitioning = false;
  let autoplayTimer = null;
  let transitionSafetyTimer = null;

  function getSlideWidth() {
    return container.getBoundingClientRect().width || container.clientWidth || 0;
  }

  function updateActiveClasses(realIndex) {
    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === realIndex);
    });
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === realIndex);
    });
  }

  function moveToTrackIndex(targetIndex, animate = true) {
    clearTimeout(transitionSafetyTimer);

    if (animate) {
      track.style.transition = 'transform 0.3s cubic-bezier(0.25, 1, 0.5, 1)';
      isTransitioning = true;
      transitionSafetyTimer = setTimeout(onTransitionComplete, 350);
    } else {
      track.style.transition = 'none';
      isTransitioning = false;
    }

    currentTrackIndex = targetIndex;
    const slideWidth = getSlideWidth();
    const offset = dirMult * currentTrackIndex * slideWidth;
    track.style.transform = `translate3d(${offset}px, 0, 0)`;

    // Calculate real slide index (0 to slides.length - 1)
    let realIndex = 0;
    if (currentTrackIndex === 0) {
      realIndex = slides.length - 1;
    } else if (currentTrackIndex === allSlides.length - 1) {
      realIndex = 0;
    } else {
      realIndex = currentTrackIndex - 1;
    }

    updateActiveClasses(realIndex);

    if (!animate) {
      void track.offsetHeight; // Force synchronous reflow
    }
  }

  function onTransitionComplete() {
    isTransitioning = false;
    clearTimeout(transitionSafetyTimer);

    // If on clone of first slide (past the end), silently jump to real first slide
    if (currentTrackIndex === allSlides.length - 1) {
      moveToTrackIndex(1, false);
    } else if (currentTrackIndex === 0) {
      // If on clone of last slide (before the start), silently jump to real last slide
      moveToTrackIndex(allSlides.length - 2, false);
    }
  }

  track.addEventListener('transitionend', (e) => {
    if (e.target !== track || e.propertyName !== 'transform') return;
    onTransitionComplete();
  });

  function nextSlide() {
    if (isTransitioning) return;
    moveToTrackIndex(currentTrackIndex + 1, true);
  }

  function prevSlide() {
    if (isTransitioning) return;
    moveToTrackIndex(currentTrackIndex - 1, true);
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
      if (isTransitioning) return;
      const targetSlide = parseInt(dot.dataset.slideTarget, 10);
      if (!isNaN(targetSlide)) {
        moveToTrackIndex(targetSlide + 1, true);
        resetAutoplay();
      }
    });
  });

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(nextSlide, 5000);
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

  // Pause autoplay when browser tab is inactive
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      stopAutoplay();
    } else {
      startAutoplay();
    }
  });

  // Touch Swipe for Mobile Hero Slider
  let touchStartX = 0;
  let touchEndX = 0;
  let touchStartY = 0;
  let touchEndY = 0;

  container.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
    stopAutoplay();
  }, { passive: true });

  container.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    touchEndY = e.changedTouches[0].screenY;
    const diffX = touchEndX - touchStartX;
    const diffY = touchEndY - touchStartY;

    if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
      if (diffX < 0) {
        // Swiped left
        nextSlide();
      } else {
        // Swiped right
        prevSlide();
      }
      resetAutoplay();
    } else {
      startAutoplay();
    }
  }, { passive: true });

  // Handle Resize smoothly
  if (typeof ResizeObserver !== 'undefined') {
    let resizeTimer = null;
    const ro = new ResizeObserver(() => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        moveToTrackIndex(currentTrackIndex, false);
      }, 50);
    });
    ro.observe(container);
  } else {
    window.addEventListener('resize', () => {
      moveToTrackIndex(currentTrackIndex, false);
    });
  }

  window.addEventListener('load', () => {
    moveToTrackIndex(currentTrackIndex, false);
  });

  // Position at original first slide immediately
  moveToTrackIndex(1, false);

  // Start autoplay
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
}

/**
 * 3. Circular Categories Responsive Scrollable Slider (6 on Desktop, 4 on Tablet, 3 on Mobile)
 * Supports smooth horizontal scrolling left/right via:
 * - Desktop Mouse Drag-to-Scroll
 * - Header Next / Prev arrow buttons
 * - Mobile Touch Swipe & Trackpad
 */
function initCategoriesCarousel() {
  const container = document.getElementById('categoriesCircleCarousel');
  if (!container) return;

  const section = container.closest('.categories-circle-section');
  const track = container.querySelector('.categories-carousel-track');
  if (!track) return;

  const isRtl =
    (window.marketData && typeof window.marketData.isRtl === 'boolean')
      ? window.marketData.isRtl
      : document.documentElement.dir === 'rtl' ||
        document.body.classList.contains('rtl') ||
        window.getComputedStyle(document.body).direction === 'rtl';

  function getScrollStep() {
    const firstSlide = track.querySelector('.category-carousel-slide');
    if (!firstSlide) return 240;
    const slideWidth = firstSlide.getBoundingClientRect().width || 120;
    // Step by 3 items on desktop, 2 on tablet, 1 on mobile
    const itemsToScroll = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
    return Math.round((slideWidth + 12) * itemsToScroll);
  }

  // Header Navigation Arrows
  const header = section ? section.querySelector('.categories-circle-header') : null;
  const prevBtn = header ? header.querySelector('.categories-nav-prev') : container.querySelector('.categories-nav-prev');
  const nextBtn = header ? header.querySelector('.categories-nav-next') : container.querySelector('.categories-nav-next');

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const step = getScrollStep();
      // In RTL, advancing to next items scrolls towards the left (negative delta)
      track.scrollBy({ left: isRtl ? -step : step, behavior: 'smooth' });
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const step = getScrollStep();
      // In RTL, going to previous items scrolls towards the right (positive delta)
      track.scrollBy({ left: isRtl ? step : -step, behavior: 'smooth' });
    });
  }

  // Desktop Mouse Drag-to-Scroll
  let isDown = false;
  let startX = 0;
  let scrollLeftStart = 0;
  let hasDragged = false;

  track.addEventListener('mousedown', (e) => {
    // Only primary (left) mouse button
    if (e.button !== 0) return;
    isDown = true;
    hasDragged = false;
    track.classList.add('is-dragging');
    startX = e.pageX - track.offsetLeft;
    scrollLeftStart = track.scrollLeft;
  });

  window.addEventListener('mouseup', () => {
    if (!isDown) return;
    isDown = false;
    track.classList.remove('is-dragging');
    setTimeout(() => {
      hasDragged = false;
    }, 60);
  });

  track.addEventListener('mouseleave', () => {
    if (!isDown) return;
    isDown = false;
    track.classList.remove('is-dragging');
    setTimeout(() => {
      hasDragged = false;
    }, 60);
  });

  track.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    const x = e.pageX - track.offsetLeft;
    const walk = (x - startX);
    if (Math.abs(walk) > 5) {
      hasDragged = true;
      e.preventDefault();
    }
    track.scrollLeft = scrollLeftStart - walk;
  });

  // Prevent opening links if user was dragging the slider
  track.addEventListener('click', (e) => {
    if (hasDragged) {
      e.preventDefault();
      e.stopPropagation();
    }
  }, true);
}

