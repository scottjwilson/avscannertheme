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

  function logError(context, error) {
    console.error(`[AVScanner] ${context}:`, error);
  }

  window.addEventListener("unhandledrejection", (e) => {
    logError("unhandled-promise", e.reason);
  });

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
  function isInViewport(el) {
    const rect = el.getBoundingClientRect();
    return rect.top < window.innerHeight && rect.bottom > 0;
  }

  function initRevealAnimations() {
    const revealElements = document.querySelectorAll(".reveal");

    if (!revealElements.length) return;

    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    }, { rootMargin: "0px 0px -10% 0px", threshold: 0.1 });

    revealElements.forEach((el) => {
      // Show above-the-fold elements immediately (IO fires async)
      if (isInViewport(el)) {
        el.classList.add("is-visible");
      } else {
        revealObserver.observe(el);
      }
    });
  }

  // ========================================
  // STAGGER CHILDREN ANIMATIONS
  // ========================================
  function initStaggerAnimations() {
    const staggerContainers = document.querySelectorAll(".stagger-children");

    if (!staggerContainers.length) return;

    const staggerObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    }, { rootMargin: "0px 0px -10% 0px", threshold: 0.1 });

    staggerContainers.forEach((el) => {
      if (isInViewport(el)) {
        el.classList.add("is-visible");
      } else {
        staggerObserver.observe(el);
      }
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
  // INFINITE SCROLL
  // ========================================
  function createSkeletons(count) {
    const template = document.getElementById("card-skeleton");
    if (!template) return [];
    return Array.from({ length: count }, () => {
      const el = template.content.cloneNode(true).firstElementChild;
      el.classList.add("infinite-scroll-skeleton");
      return el;
    });
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

      // ARIA live region for screen reader announcements
      const scrollStatus = document.createElement('div');
      scrollStatus.className = 'sr-only';
      scrollStatus.setAttribute('aria-live', 'polite');
      scrollStatus.setAttribute('aria-atomic', 'true');
      grid.parentNode.insertBefore(scrollStatus, grid.nextSibling);

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
            `/wp-json/avscannertheme/v1/cards?${params}`,
          );
          if (!resp.ok) throw new Error(resp.statusText);

          const data = await resp.json();
          const newTotal =
            parseInt(resp.headers.get("X-WP-TotalPages")) || totalPages;

          // Remove skeletons
          skeletons.forEach((s) => s.remove());

          // Insert pre-rendered HTML cards
          data.cards.forEach((html) => {
            grid.insertAdjacentHTML("beforeend", html);
          });

          scrollStatus.textContent = `Loaded ${data.cards.length} more posts`;

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
          logError("infinite-scroll", err);
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
  // INLINE / AJAX SEARCH
  // ========================================
  function escHTML(str) {
    const div = document.createElement("div");
    div.textContent = str || "";
    return div.innerHTML;
  }

  function initInlineSearch() {
    const input = document.getElementById("header-search-input");
    const dropdown = document.getElementById("search-dropdown");
    if (!input || !dropdown) return;

    // Overlay elements
    const overlay = document.querySelector(".search-overlay");
    const overlayInput = overlay?.querySelector(".search-overlay-input");
    const overlayResults = overlay?.querySelector(".search-overlay-results");
    const overlayBack = overlay?.querySelector(".search-overlay-back");
    const searchTrigger = document.querySelector(".search-trigger");

    // Mobile detection
    const mobileMQ = window.matchMedia("(max-width: 639px)");

    let debounceTimer = null;
    let controller = null;
    let activeIndex = -1;

    // --- Shared search/render logic ---

    function renderResults(target, html) {
      target.innerHTML = html;
    }

    function showDropdown(html) {
      dropdown.innerHTML = html;
      dropdown.hidden = false;
      input.setAttribute("aria-expanded", "true");
    }

    function hideDropdown() {
      dropdown.hidden = true;
      dropdown.innerHTML = "";
      input.setAttribute("aria-expanded", "false");
      activeIndex = -1;
    }

    function getItems(container) {
      return container.querySelectorAll(".search-dropdown-item");
    }

    function setActive(container, index) {
      const items = getItems(container);
      items.forEach((el) => el.classList.remove("is-active"));
      activeIndex = index;
      if (items[activeIndex]) {
        items[activeIndex].classList.add("is-active");
        items[activeIndex].scrollIntoView({ block: "nearest" });
      }
    }

    function buildResultsHTML(posts, query, formAction) {
      if (!posts.length) {
        return '<div class="search-dropdown-empty">No results found</div>';
      }

      const itemsHTML = posts
        .map((p) => {
          const thumb = p.thumbnail_url
            ? `<img class="search-dropdown-thumb" src="${p.thumbnail_url}" alt="" loading="lazy" decoding="async">`
            : "";
          const badge =
            p.categories_detail?.length
              ? `<span class="badge badge-${p.categories_detail[0].slug}">${escHTML(p.categories_detail[0].name)}</span>`
              : "";
          return `<a class="search-dropdown-item" href="${p.permalink}" role="option" tabindex="-1">
            ${thumb}
            <span class="search-dropdown-body">
              <span class="search-dropdown-title">${escHTML(p.title)}</span>
              <span class="search-dropdown-meta">${badge}<span>${escHTML(p.date_short)}</span></span>
            </span>
          </a>`;
        })
        .join("");

      const footerHTML = `<a class="search-dropdown-footer" href="${formAction}?s=${encodeURIComponent(query)}&post_type=fb_post" tabindex="-1">View all results \u2192</a>`;

      return itemsHTML + footerHTML;
    }

    async function doSearch(query, target, formAction) {
      if (controller) controller.abort();
      controller = new AbortController();

      const isOverlay = target === overlayResults;
      if (isOverlay) {
        renderResults(target, '<div class="search-dropdown-loading">Searching\u2026</div>');
      } else {
        showDropdown('<div class="search-dropdown-loading">Searching\u2026</div>');
      }

      try {
        const resp = await fetch(
          `/wp-json/avscanner/v1/posts?search=${encodeURIComponent(query)}&per_page=5`,
          { signal: controller.signal }
        );
        if (!resp.ok) throw new Error(resp.statusText);
        const posts = await resp.json();
        const html = buildResultsHTML(posts, query, formAction);

        if (isOverlay) {
          renderResults(target, html);
        } else {
          showDropdown(html);
        }
        activeIndex = -1;
      } catch (err) {
        if (err.name === "AbortError") return;
        logError("inline-search", err);
        if (isOverlay) {
          renderResults(target, "");
        } else {
          hideDropdown();
        }
      }
    }

    // --- Desktop inline search (unchanged behavior) ---

    input.addEventListener("input", () => {
      clearTimeout(debounceTimer);
      const query = input.value.trim();
      if (query.length < 2) {
        hideDropdown();
        return;
      }
      const formAction = input.closest("form").action;
      debounceTimer = setTimeout(() => doSearch(query, dropdown, formAction), 300);
    });

    input.addEventListener("keydown", (e) => {
      if (dropdown.hidden) return;

      if (e.key === "Tab") {
        hideDropdown();
        return;
      }

      const items = getItems(dropdown);
      if (!items.length) return;

      if (e.key === "ArrowDown") {
        e.preventDefault();
        setActive(dropdown, activeIndex < items.length - 1 ? activeIndex + 1 : 0);
      } else if (e.key === "ArrowUp") {
        e.preventDefault();
        setActive(dropdown, activeIndex > 0 ? activeIndex - 1 : items.length - 1);
      } else if (e.key === "Enter") {
        if (activeIndex >= 0 && items[activeIndex]) {
          e.preventDefault();
          items[activeIndex].click();
        }
      } else if (e.key === "Escape") {
        e.preventDefault();
        hideDropdown();
      }
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".header-search-wrap")) {
        hideDropdown();
      }
    });

    input.addEventListener("focus", () => {
      if (input.value.trim().length >= 2 && dropdown.innerHTML && dropdown.hidden) {
        dropdown.hidden = false;
        input.setAttribute("aria-expanded", "true");
      }
    });

    // --- Mobile overlay ---

    if (!overlay || !overlayInput || !overlayResults || !overlayBack || !searchTrigger) return;

    let savedScrollY = 0;

    function openOverlay() {
      savedScrollY = window.scrollY;
      overlay.hidden = false;
      document.body.classList.add("search-open");
      document.body.style.top = `-${savedScrollY}px`;
      // Focus synchronously within the click event so mobile browsers show the keyboard
      overlayInput.focus();
      // If there's already text, re-run search
      const query = overlayInput.value.trim();
      if (query.length >= 2) {
        const formAction = overlayInput.closest("form").action;
        doSearch(query, overlayResults, formAction);
      }
      // Trap focus within overlay
      overlay.addEventListener("keydown", trapFocus);
    }

    function closeOverlay() {
      overlay.hidden = true;
      document.body.classList.remove("search-open");
      document.body.style.top = "";
      window.scrollTo(0, savedScrollY);
      renderResults(overlayResults, "");
      activeIndex = -1;
      overlay.removeEventListener("keydown", trapFocus);
      searchTrigger.focus();
    }

    function trapFocus(e) {
      if (e.key !== "Tab") return;
      const focusable = overlay.querySelectorAll(
        'button, [href], input, [tabindex]:not([tabindex="-1"])'
      );
      if (!focusable.length) return;
      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      if (e.shiftKey) {
        if (document.activeElement === first) {
          e.preventDefault();
          last.focus();
        }
      } else {
        if (document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    }

    searchTrigger.addEventListener("click", openOverlay);
    overlayBack.addEventListener("click", closeOverlay);

    // Dismiss keyboard as soon as the user starts dragging through results
    overlayResults.addEventListener("touchstart", () => overlayInput.blur(), { passive: true });

    // Overlay input search
    overlayInput.addEventListener("input", () => {
      clearTimeout(debounceTimer);
      const query = overlayInput.value.trim();
      if (query.length < 2) {
        renderResults(overlayResults, "");
        return;
      }
      const formAction = overlayInput.closest("form").action;
      debounceTimer = setTimeout(() => doSearch(query, overlayResults, formAction), 300);
    });

    // Overlay keyboard navigation
    overlayInput.addEventListener("keydown", (e) => {
      const items = getItems(overlayResults);

      if (e.key === "Escape") {
        e.preventDefault();
        closeOverlay();
        return;
      }

      if (!items.length) return;

      if (e.key === "ArrowDown") {
        e.preventDefault();
        setActive(overlayResults, activeIndex < items.length - 1 ? activeIndex + 1 : 0);
      } else if (e.key === "ArrowUp") {
        e.preventDefault();
        setActive(overlayResults, activeIndex > 0 ? activeIndex - 1 : items.length - 1);
      } else if (e.key === "Enter") {
        if (activeIndex >= 0 && items[activeIndex]) {
          e.preventDefault();
          items[activeIndex].click();
        }
      }
    });

    // Close overlay when a result is tapped
    overlayResults.addEventListener("click", (e) => {
      if (e.target.closest(".search-dropdown-item")) {
        closeOverlay();
      }
    });

    // Global Escape to close overlay
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && !overlay.hidden) {
        closeOverlay();
      }
    });
  }

  // ========================================
  // SCROLL POSITION RESTORE
  // ========================================
  function initScrollRestore() {
    const STORAGE_KEY = "avs_scroll_pos";
    const grid = document.querySelector("[data-infinite-scroll]");

    if (grid) {
      // Save scroll position when clicking a card link
      grid.addEventListener("click", (e) => {
        const link = e.target.closest("a");
        if (!link) return;
        sessionStorage.setItem(
          STORAGE_KEY,
          JSON.stringify({ scrollY: window.scrollY })
        );
      });

      // Restore scroll position on page load
      const saved = sessionStorage.getItem(STORAGE_KEY);
      if (saved) {
        sessionStorage.removeItem(STORAGE_KEY);
        try {
          const { scrollY } = JSON.parse(saved);
          if (scrollY) {
            requestAnimationFrame(() => window.scrollTo(0, scrollY));
          }
        } catch (e) {}
      }
    }
  }

  // ========================================
  // SHARE BUTTONS
  // ========================================
  function initShareButtons() {
    // Native share (mobile) — hide desktop buttons, show native button
    const hasNativeShare = !!navigator.share;
    document.querySelectorAll(".share-btn-native").forEach((btn) => {
      if (!hasNativeShare) return;
      btn.hidden = false;
      btn.nextElementSibling?.classList.add("share-buttons-hidden");
      btn.addEventListener("click", async () => {
        try {
          await navigator.share({
            title: btn.dataset.shareTitle,
            url: btn.dataset.shareUrl,
          });
        } catch {}
      });
    });

    // Copy link button (desktop)
    document.querySelectorAll(".copy-link-btn").forEach((btn) => {
      btn.addEventListener("click", async () => {
        try {
          await navigator.clipboard.writeText(btn.dataset.url || location.href);
          btn.classList.add("is-copied");
          setTimeout(() => btn.classList.remove("is-copied"), 2000);
        } catch {}
      });
    });
  }

  // ========================================
  // SCANNER CODES SEARCH
  // ========================================
  function initCodesSearch() {
    const input = document.getElementById("codes-search-input");
    if (!input) return;

    const sections = document.querySelectorAll(".codes-section");
    const rows = document.querySelectorAll(".codes-row");
    const matchCount = document.getElementById("codes-match-count");
    const emptyState = document.getElementById("codes-empty");
    const navTabs = document.querySelectorAll(".codes-nav-tab");

    input.addEventListener("input", () => {
      const query = input.value.trim().toLowerCase();

      if (!query) {
        rows.forEach((row) => (row.hidden = false));
        sections.forEach((s) => s.classList.remove("is-hidden"));
        if (matchCount) matchCount.hidden = true;
        if (emptyState) emptyState.hidden = true;
        return;
      }

      let total = 0;

      rows.forEach((row) => {
        const code = row.dataset.code || "";
        const desc = row.dataset.desc || "";
        const match = code.includes(query) || desc.includes(query);
        row.hidden = !match;
        if (match) total++;
      });

      // Hide sections with no visible rows
      sections.forEach((section) => {
        const visible = section.querySelectorAll(".codes-row:not([hidden])");
        section.classList.toggle("is-hidden", visible.length === 0);
      });

      // Match count
      if (matchCount) {
        matchCount.textContent = `${total} result${total !== 1 ? "s" : ""}`;
        matchCount.hidden = false;
      }

      // Empty state
      if (emptyState) {
        emptyState.hidden = total > 0;
      }
    });

    // Section nav: clear search and highlight active tab
    navTabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        input.value = "";
        input.dispatchEvent(new Event("input"));
        navTabs.forEach((t) => t.classList.remove("is-active"));
        tab.classList.add("is-active");
      });
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
      initRevealAnimations();
      initStaggerAnimations();
      initSmoothScroll();
    }
    initInlineSearch();
    initScrollRestore();
    initInfiniteScroll();
    initImageFadeIn();
    setCurrentYear();
    initBackToTop();
    initShareButtons();
    initCodesSearch();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
