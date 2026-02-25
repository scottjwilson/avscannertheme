import "../css/variables.css";
import "../css/base.css";
import "../css/layout.css";
import "../css/header.css";
import "../css/category-nav.css";
import "../css/footer.css";
import "../css/search.css";
import "../css/front-page.css";

/**
 * AVScannerTheme
 * Main JavaScript
 */

(function () {
  "use strict";

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
  // INFINITE SCROLL
  // ========================================
  function escHTML(str) {
    const div = document.createElement("div");
    div.textContent = str || "";
    return div.innerHTML;
  }

  function createSkeletons(count) {
    const template = document.getElementById("card-skeleton");
    if (!template) return [];
    return Array.from({ length: count }, () => {
      const el = template.content.cloneNode(true).firstElementChild;
      el.classList.add("infinite-scroll-skeleton");
      return el;
    });
  }

  function buildCard(post) {
    const article = document.createElement("article");
    const isAd = post.categories_detail?.some((c) => c.slug === "advertisement");
    article.className = "card card-hover" + (isAd ? " card-sponsored" : "");

    let imageHTML = "";
    if (post.thumbnail_url || post.thumbnail_html) {
      const videoClass = post.video_url ? " has-video" : "";
      const playIcon = post.video_url
        ? '<span class="card-play-icon" aria-hidden="true"><svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="24" fill="rgba(0,0,0,0.6)"/><path d="M19 15l14 9-14 9V15z" fill="white"/></svg></span>'
        : "";
      const imgTag = post.thumbnail_html
        ? post.thumbnail_html
        : `<img src="${post.thumbnail_url}" alt="${escHTML(post.title)}" loading="lazy" decoding="async">`;
      imageHTML = `<a href="${post.permalink}" class="card-image-link${videoClass}"><div class="card-image">${imgTag}${playIcon}</div></a>`;
    }

    let badgesHTML = "";
    if (post.categories_detail?.length) {
      if (isAd) {
        badgesHTML =
          '<div class="card-badges"><span class="badge badge-sponsored">Sponsored</span></div>';
      } else {
        badgesHTML =
          '<div class="card-badges">' +
          post.categories_detail
            .map(
              (c) =>
                `<a href="${c.link}" class="badge badge-${c.slug}">${escHTML(c.name)}</a>`,
            )
            .join("") +
          "</div>";
      }
    }

    let sourceHTML = "";
    if (post.shared_url) {
      try {
        const host = new URL(post.shared_url).hostname;
        sourceHTML = `<span class="card-source">via ${escHTML(host)}</span>`;
      } catch (e) {}
    }

    article.innerHTML = `
        ${imageHTML}
        <span class="card-date">${escHTML(post.date_short)} at ${escHTML(post.time)}</span>
        ${badgesHTML}
        ${sourceHTML}
        <h3 class="card-title"><a href="${post.permalink}">${escHTML(post.title)}</a></h3>
        <p class="card-text">${escHTML(post.excerpt_short)}</p>
        <a href="${post.permalink}" class="card-link">Read more <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M4.167 10h11.666M10 4.167L15.833 10 10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    `;
    return article;
  }

  function initInfiniteScroll() {
    const grids = document.querySelectorAll("[data-infinite-scroll]");
    if (!grids.length) return;

    grids.forEach((grid) => {
      const perPage = parseInt(grid.dataset.perPage) || 12;
      const totalPages = parseInt(grid.dataset.totalPages) || 1;
      const category = grid.dataset.category || "";
      let currentPage = parseInt(grid.dataset.currentPage) || 1;
      let loading = false;

      const controls = grid.nextElementSibling; // .infinite-scroll-controls
      if (!controls) return;
      const sentinel = controls.querySelector(".infinite-scroll-sentinel");
      const loadMoreBtn = controls.querySelector(".infinite-scroll-load-more");
      const status = controls.querySelector(".infinite-scroll-status");

      if (currentPage >= totalPages) return; // No more pages

      // IntersectionObserver on sentinel
      const observer = new IntersectionObserver(
        (entries) => {
          if (entries[0].isIntersecting && !loading) {
            loadNextPage();
          }
        },
        { rootMargin: "200px" },
      );
      observer.observe(sentinel);

      // Manual fallback button
      loadMoreBtn.hidden = false;
      loadMoreBtn.addEventListener("click", loadNextPage);

      async function loadNextPage() {
        if (loading || currentPage >= totalPages) return;
        loading = true;
        loadMoreBtn.hidden = true;
        status.hidden = false;
        status.textContent = "Loading more posts\u2026";

        // Show skeleton placeholders
        const skeletons = createSkeletons(3);
        grid.append(...skeletons);

        try {
          const params = new URLSearchParams({
            page: currentPage + 1,
            per_page: perPage,
          });
          if (category) params.set("category", category);

          const resp = await fetch(
            `/wp-json/avscanner/v1/posts?${params}`,
          );
          if (!resp.ok) throw new Error(resp.statusText);

          const posts = await resp.json();
          const newTotal =
            parseInt(resp.headers.get("X-WP-TotalPages")) || totalPages;

          // Remove skeletons
          skeletons.forEach((s) => s.remove());

          // Render cards
          posts.forEach((post) => {
            const card = buildCard(post);
            grid.appendChild(card);
          });

          currentPage++;
          grid.dataset.currentPage = currentPage;

          if (currentPage >= newTotal) {
            observer.disconnect();
            loadMoreBtn.hidden = true;
            status.hidden = false;
            status.textContent = "All posts loaded";
          } else {
            loadMoreBtn.hidden = false;
            status.hidden = true;
          }

          // Trigger image fade-in for new cards
          initImageFadeIn();
        } catch (err) {
          skeletons.forEach((s) => s.remove());
          loadMoreBtn.hidden = false;
          status.hidden = false;
          status.textContent = "Failed to load — try again";
        }
        loading = false;
      }
    });
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
    if (!prefersReducedMotion) {
      initSkeletonLoaders();
      initRevealAnimations();
      initStaggerAnimations();
      initSmoothScroll();
    }
    initInfiniteScroll();
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
