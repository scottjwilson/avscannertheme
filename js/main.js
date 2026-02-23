import "../css/variables.css";
import "../css/base.css";
import "../css/layout.css";
import "../css/header.css";
import "../css/category-nav.css";
import "../css/footer.css";
import "../css/search.css";
import "../css/front-page.css";

/**
 * Clean Vite WP
 * Main JavaScript
 */

(function () {
  "use strict";

  // ========================================
  // HEADER SCROLL BEHAVIOR
  // ========================================
  const header = document.querySelector(".site-header");
  const categoryNav = document.querySelector(".category-nav");

  function handleHeaderScroll() {
    if (window.scrollY > 50) {
      header?.classList.add("is-scrolled");
      categoryNav?.classList.add("is-scrolled");
    } else {
      header?.classList.remove("is-scrolled");
      categoryNav?.classList.remove("is-scrolled");
    }
  }

  // ========================================
  // MOBILE MENU
  // ========================================
  const menuToggle = document.querySelector(".menu-toggle");
  const mobileNav = document.querySelector(".nav-mobile");

  function toggleMobileMenu() {
    const isOpen = menuToggle?.getAttribute("aria-expanded") === "true";

    menuToggle?.setAttribute("aria-expanded", !isOpen);
    mobileNav?.classList.toggle("is-open");
    mobileNav?.setAttribute("aria-hidden", isOpen);
    document.body.classList.toggle("menu-open");
  }

  function closeMobileMenu() {
    menuToggle?.setAttribute("aria-expanded", "false");
    mobileNav?.classList.remove("is-open");
    mobileNav?.setAttribute("aria-hidden", "true");
    document.body.classList.remove("menu-open");
  }

  // ========================================
  // REVEAL ANIMATIONS (INTERSECTION OBSERVER)
  // ========================================
  function initRevealAnimations() {
    const revealElements = document.querySelectorAll(".reveal");

    if (!revealElements.length) return;

    const observerOptions = {
      root: null,
      rootMargin: "0px 0px -10% 0px",
      threshold: 0.1,
    };

    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    }, observerOptions);

    revealElements.forEach((el) => {
      revealObserver.observe(el);
    });
  }

  // ========================================
  // STAGGER CHILDREN ANIMATIONS
  // ========================================
  function initStaggerAnimations() {
    const staggerContainers = document.querySelectorAll(".stagger-children");

    if (!staggerContainers.length) return;

    const observerOptions = {
      root: null,
      rootMargin: "0px 0px -10% 0px",
      threshold: 0.1,
    };

    const staggerObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    }, observerOptions);

    staggerContainers.forEach((el) => {
      staggerObserver.observe(el);
    });
  }

  // ========================================
  // SMOOTH SCROLL FOR ANCHOR LINKS
  // ========================================
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");

        if (href === "#") return;

        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          const headerHeight = header?.offsetHeight || 0;
          const targetPosition =
            target.getBoundingClientRect().top +
            window.pageYOffset -
            headerHeight -
            20;

          window.scrollTo({
            top: targetPosition,
            behavior: "smooth",
          });

          closeMobileMenu();
        }
      });
    });
  }

  // ========================================
  // IMAGE FADE-IN ON LOAD
  // ========================================
  function initImageFadeIn() {
    const images = document.querySelectorAll('.card-image img, .single-image img');
    images.forEach((img) => {
      if (img.complete && img.naturalHeight > 0) {
        img.classList.add('is-loaded');
      } else {
        img.addEventListener('load', () => img.classList.add('is-loaded'), { once: true });
        img.addEventListener('error', () => img.classList.add('is-loaded'), { once: true });
      }
    });
  }

  // ========================================
  // CURRENT YEAR (FOOTER)
  // ========================================
  function setCurrentYear() {
    const yearElements = document.querySelectorAll("[data-year]");
    const currentYear = new Date().getFullYear();

    yearElements.forEach((el) => {
      el.textContent = currentYear;
    });
  }

  // ========================================
  // THEME TOGGLE (DARK / LIGHT)
  // ========================================
  function initThemeToggle() {
    const toggle = document.querySelector(".theme-toggle");
    if (!toggle) return;

    // Restore saved preference
    const saved = localStorage.getItem("cvw-theme");
    if (saved === "light" || saved === "dark") {
      document.documentElement.dataset.theme = saved;
    }

    toggle.addEventListener("click", () => {
      const current = document.documentElement.dataset.theme;
      const next = current === "light" ? "dark" : "light";
      document.documentElement.dataset.theme = next;
      localStorage.setItem("cvw-theme", next);
    });
  }

  // ========================================
  // BACK TO TOP
  // ========================================
  function initBackToTop() {
    const backToTop = document.querySelector(".back-to-top");
    if (!backToTop) return;

    window.addEventListener(
      "scroll",
      () => {
        if (window.scrollY > 400) {
          backToTop.hidden = false;
          requestAnimationFrame(() => backToTop.classList.add("is-visible"));
        } else {
          backToTop.classList.remove("is-visible");
          backToTop.addEventListener(
            "transitionend",
            () => {
              if (!backToTop.classList.contains("is-visible"))
                backToTop.hidden = true;
            },
            { once: true },
          );
        }
      },
      { passive: true },
    );

    backToTop.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // ========================================
  // SKELETON LOADERS
  // ========================================
  function initSkeletonLoaders() {
    const grids = document.querySelectorAll('.grid.stagger-children');
    const template = document.getElementById('card-skeleton');
    if (!grids.length || !template) return;

    grids.forEach((grid) => {
      const cards = grid.querySelectorAll('.card');
      if (!cards.length) return;

      // Clone skeletons to match card count (cap at visible count)
      const count = Math.min(cards.length, 6);
      const skeletonWrap = document.createElement('div');
      skeletonWrap.className = 'skeleton-grid';
      skeletonWrap.classList.add('grid', 'grid-3');

      for (let i = 0; i < count; i++) {
        skeletonWrap.appendChild(template.content.cloneNode(true));
      }

      grid.parentNode.insertBefore(skeletonWrap, grid);
      grid.style.display = 'none';

      // Wait for all images in this grid to load
      const images = grid.querySelectorAll('.card-image img');
      if (!images.length) {
        removeSkeleton(skeletonWrap, grid);
        return;
      }

      let loaded = 0;
      const total = images.length;

      function onImageReady() {
        loaded++;
        if (loaded >= total) {
          removeSkeleton(skeletonWrap, grid);
        }
      }

      images.forEach((img) => {
        if (img.complete && img.naturalHeight > 0) {
          onImageReady();
        } else {
          img.addEventListener('load', onImageReady, { once: true });
          img.addEventListener('error', onImageReady, { once: true });
        }
      });

      // Safety timeout — don't block forever on slow images
      setTimeout(() => removeSkeleton(skeletonWrap, grid), 5000);
    });
  }

  function removeSkeleton(skeletonWrap, grid) {
    if (!skeletonWrap.parentNode) return; // Already removed
    skeletonWrap.classList.add('skeleton-fade-out');
    grid.style.display = '';
    skeletonWrap.addEventListener('transitionend', () => {
      skeletonWrap.remove();
    }, { once: true });
    // Fallback removal if transition doesn't fire
    setTimeout(() => skeletonWrap.remove(), 400);
  }

  // ========================================
  // INITIALIZE
  // ========================================
  function init() {
    window.addEventListener("scroll", handleHeaderScroll, { passive: true });
    menuToggle?.addEventListener("click", toggleMobileMenu);

    mobileNav?.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", closeMobileMenu);
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        closeMobileMenu();
      }
    });

    handleHeaderScroll();
    initThemeToggle();
    initSkeletonLoaders();
    initRevealAnimations();
    initStaggerAnimations();
    initSmoothScroll();
    initImageFadeIn();
    setCurrentYear();
    initBackToTop();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
