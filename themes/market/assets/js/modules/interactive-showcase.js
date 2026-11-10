/**
 * Market Theme — Interactive Showcase Hotspots Module
 *
 * Provides responsive hotspot positioning, mobile tap-to-reveal tooltips,
 * desktop hover inspection, boundary-aware tooltip clamping, and link navigation.
 */

export function initInteractiveShowcase() {
  const stage = document.getElementById('interactiveStage');
  if (!stage) return;

  const points = stage.querySelectorAll('.hotspot-point');
  if (!points.length) return;

  /**
   * Adjusts the tooltip's horizontal transform so it never bleeds outside the viewport.
   */
  function clampTooltip(point) {
    const tooltip = point.querySelector('.hotspot-tooltip');
    if (!tooltip) return;

    // Reset inline transform to base centered position to accurately measure bounds
    tooltip.style.transform = 'translateX(50%) translateY(0)';

    const rect = tooltip.getBoundingClientRect();
    const viewportWidth = document.documentElement.clientWidth;
    const padding = 12; // Minimum distance from screen edge

    let offsetX = 0;

    if (rect.right > viewportWidth - padding) {
      offsetX = rect.right - (viewportWidth - padding);
    } else if (rect.left < padding) {
      offsetX = -(padding - rect.left);
    }

    if (offsetX !== 0) {
      tooltip.style.transform = `translateX(calc(50% - ${offsetX}px)) translateY(0)`;
    }
  }

  function resetTooltipTransform(point) {
    const tooltip = point.querySelector('.hotspot-tooltip');
    if (tooltip) {
      tooltip.style.transform = '';
    }
  }

  function closeAllHotspots(exceptPoint = null) {
    points.forEach((p) => {
      if (p !== exceptPoint && p.classList.contains('is-active')) {
        p.classList.remove('is-active');
        const trigger = p.querySelector('.hotspot-trigger');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
        const tooltip = p.querySelector('.hotspot-tooltip');
        if (tooltip) tooltip.setAttribute('aria-hidden', 'true');
        resetTooltipTransform(p);
      }
    });
  }

  function openHotspot(point) {
    closeAllHotspots(point);
    point.classList.add('is-active');
    const trigger = point.querySelector('.hotspot-trigger');
    if (trigger) trigger.setAttribute('aria-expanded', 'true');
    const tooltip = point.querySelector('.hotspot-tooltip');
    if (tooltip) tooltip.setAttribute('aria-hidden', 'false');
    clampTooltip(point);
  }

  function toggleHotspot(point) {
    if (point.classList.contains('is-active')) {
      closeAllHotspots();
    } else {
      openHotspot(point);
    }
  }

  // Event bindings for each hotspot
  points.forEach((point) => {
    const trigger = point.querySelector('.hotspot-trigger');
    const tooltip = point.querySelector('.hotspot-tooltip');

    if (trigger) {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        toggleHotspot(point);
      });
    }

    // Stop propagation inside tooltip so clicking the card or button does not trigger document click
    if (tooltip) {
      tooltip.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    }

    // Desktop hover: ensure tooltip is clamped to viewport bounds
    point.addEventListener('mouseenter', () => {
      clampTooltip(point);
    });

    point.addEventListener('mouseleave', () => {
      if (!point.classList.contains('is-active')) {
        resetTooltipTransform(point);
      }
    });
  });

  // Tap or click outside closes any active tooltip
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.hotspot-point')) {
      closeAllHotspots();
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeAllHotspots();
    }
  });

  // Handle window resizing or orientation changes
  window.addEventListener(
    'resize',
    () => {
      const active = stage.querySelector('.hotspot-point.is-active');
      if (active) {
        clampTooltip(active);
      }
    },
    { passive: true }
  );
}

