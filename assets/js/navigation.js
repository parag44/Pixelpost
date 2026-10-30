/**
 * Pixelpost Navigation, Smooth Scrolling & ScrollSpy
 */
(function() {
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {
    var toggleButton = document.querySelector('.pixelpost-menu-toggle, .fp-menu-toggle');
    var closeButton  = document.querySelector('.pixelpost-menu-close');
    var nav          = document.querySelector('.fp-main-navigation, #site-navigation');

    // Helper: Find all focusable elements visible within a container
    function getFocusableElements(container) {
      if (!container) return [];
      var nodes = container.querySelectorAll('button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])');
      return Array.prototype.filter.call(nodes, function(node) {
        return !!(node.offsetWidth || node.offsetHeight || node.getClientRects().length);
      });
    }

    // Open & Close handlers with proper ARIA and focus trapping
    function openMobileMenu() {
      if (!nav) return;
      nav.classList.add('is-open');
      nav.removeAttribute('aria-hidden');
      if (toggleButton) {
        toggleButton.setAttribute('aria-expanded', 'true');
      }
      document.body.classList.add('pixelpost-menu-open');

      // Put focus on the close button per Theme Review requirements
      if (closeButton) {
        setTimeout(function() {
          closeButton.focus();
        }, 50);
      }
    }

    function closeMobileMenu(returnFocus) {
      if (returnFocus === undefined) {
        returnFocus = true;
      }
      if (!nav) return;
      nav.classList.remove('is-open');
      if (window.innerWidth < 1024) {
        nav.setAttribute('aria-hidden', 'true');
      }
      if (toggleButton) {
        toggleButton.setAttribute('aria-expanded', 'false');
        if (returnFocus) {
          toggleButton.focus();
        }
      }
      document.body.classList.remove('pixelpost-menu-open');
    }

    // 1. Mobile Menu Toggle & Focus Trap
    if (toggleButton && nav) {
      if (window.innerWidth < 1024) {
        nav.setAttribute('aria-hidden', 'true');
      }

      window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
          nav.removeAttribute('aria-hidden');
          nav.classList.remove('is-open');
          document.body.classList.remove('pixelpost-menu-open');
          if (toggleButton) {
            toggleButton.setAttribute('aria-expanded', 'false');
          }
        } else if (!nav.classList.contains('is-open')) {
          nav.setAttribute('aria-hidden', 'true');
        }
      });

      toggleButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (nav.classList.contains('is-open')) {
          closeMobileMenu(true);
        } else {
          openMobileMenu();
        }
      });

      if (closeButton) {
        closeButton.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          closeMobileMenu(true);
        });
      }

      // Trap focus inside the mobile menu modal per Theme Review guidelines
      document.addEventListener('keydown', function(event) {
        if (!nav || !nav.classList.contains('is-open')) return;

        if (event.key === 'Escape') {
          event.preventDefault();
          closeMobileMenu(true);
          return;
        }

        if (event.key === 'Tab') {
          var focusables = getFocusableElements(nav);
          if (focusables.length === 0) return;

          var firstElement = focusables[0]; // Close button is the first element
          var lastElement  = focusables[focusables.length - 1]; // Last visible element

          // If focus is currently outside nav, bring it to firstElement
          if (!nav.contains(document.activeElement)) {
            event.preventDefault();
            firstElement.focus();
            return;
          }

          if (event.shiftKey) {
            // Shift + Tab (backwards): If on close button, wrap to last menu element
            if (document.activeElement === firstElement) {
              event.preventDefault();
              lastElement.focus();
            }
          } else {
            // Tab (forwards): If on last element, wrap to close button
            if (document.activeElement === lastElement) {
              event.preventDefault();
              firstElement.focus();
            }
          }
        }
      });

      // Close mobile menu if clicked outside
      document.addEventListener('click', function(e) {
        if (
          nav.classList.contains('is-open') &&
          !nav.contains(e.target) &&
          !toggleButton.contains(e.target)
        ) {
          closeMobileMenu(true);
        }
      });

      // Close mobile menu on regular link clicks
      nav.addEventListener('click', function(e) {
        var link = e.target.closest('a');
        if (link && !link.classList.contains('pixelpost-submenu-toggle')) {
          var href = link.getAttribute('href');
          if (href && href.indexOf('#') === -1) {
            closeMobileMenu(false);
          }
        }
      });
    }

    // 1b. Accessible Hierarchical Submenus
    if (nav) {
      var parentItems = nav.querySelectorAll('.menu-item-has-children');
      parentItems.forEach(function(item) {
        var link = item.querySelector(':scope > a');
        if (!link) return;

        var subMenu = item.querySelector(':scope > .sub-menu');
        if (!subMenu) return;

        // Submenu toggle button for touch/keyboard
        var toggleBtn = document.createElement('button');
        toggleBtn.className = 'pixelpost-submenu-toggle';
        toggleBtn.setAttribute('type', 'button');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.setAttribute('aria-label', 'Toggle child menu');
        toggleBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';

        link.insertAdjacentElement('afterend', toggleBtn);

        toggleBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          var isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
          toggleBtn.setAttribute('aria-expanded', !isExpanded);
          item.classList.toggle('focus');
          subMenu.classList.toggle('toggled-on');
        });

        // Toggle focus class for keyboard tabbing
        item.addEventListener('focusin', function() {
          item.classList.add('focus');
        });

        item.addEventListener('focusout', function(e) {
          if (!item.contains(e.relatedTarget)) {
            item.classList.remove('focus');
            toggleBtn.setAttribute('aria-expanded', 'false');
            subMenu.classList.remove('toggled-on');
          }
        });
      });
    }

    // Helper: Find on-page target element for any anchor link
    function getAnchorTarget(link) {
      var href = link.getAttribute('href');
      if (!href) return null;
      var hashIdx = href.indexOf('#');
      if (hashIdx === -1 || href.length <= hashIdx + 1) return null;
      var hash = href.substring(hashIdx);
      var path = href.substring(0, hashIdx);
      var currentPath = window.location.pathname;

      if (
        path === '' ||
        path === '/' ||
        path === currentPath ||
        path.replace(/\/$/, '') === currentPath.replace(/\/$/, '') ||
        href.startsWith(window.location.origin + currentPath)
      ) {
        try {
          return document.querySelector(hash);
        } catch (err) {
          return null;
        }
      }
      return null;
    }

    // 2. Navigation Link & Target Mapping
    var navLinks = nav ? Array.prototype.slice.call(nav.querySelectorAll('a')) : [];
    var trackedPairs = [];

    navLinks.forEach(function(link) {
      var target = getAnchorTarget(link);
      if (target && target.id) {
        trackedPairs.push({
          link: link,
          section: target,
          id: target.id
        });
      }
    });

    // Helper: Set Active Nav Link
    function setActiveLink(activeLink) {
      navLinks.forEach(function(link) {
        var isCurrent = (link === activeLink);
        if (isCurrent) {
          link.classList.add('active', 'text-primary');
          link.classList.remove('text-on-surface-variant');
          link.setAttribute('aria-current', 'page');
          if (link.parentElement && link.parentElement.tagName === 'LI') {
            link.parentElement.classList.add('current-menu-item');
          }
        } else {
          link.classList.remove('active', 'text-primary');
          link.classList.add('text-on-surface-variant');
          link.removeAttribute('aria-current');
          if (link.parentElement && link.parentElement.tagName === 'LI') {
            link.parentElement.classList.remove('current-menu-item');
          }
        }
      });
    }

    // 3. Smooth Scrolling for Navigation & Hash Links
    var allLinks = document.querySelectorAll('a[href*="#"]');
    allLinks.forEach(function(link) {
      var target = getAnchorTarget(link);
      if (target) {
        link.addEventListener('click', function(e) {
          e.preventDefault();

          // Close mobile menu if open without hijacking scroll focus
          if (nav && nav.classList.contains('is-open')) {
            closeMobileMenu(false);
          }

          // Smooth scroll to target (scroll-margin-top handles header offset)
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });

          // Update hash in URL
          if (history.pushState) {
            history.pushState(null, null, '#' + target.id);
          }

          // If link is in main navigation, update active state immediately
          if (nav && nav.contains(link)) {
            setActiveLink(link);
          }
        });
      }
    });

    // 4. Back to Top Smooth Scroll
    var backToTop = document.querySelector('.fp-back-to-top');
    if (backToTop) {
      backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
        if (history.pushState) {
          history.pushState(null, null, ' ');
        }
        setActiveLink(null);
      });
    }

    // 5. ScrollSpy
    var isTicking = false;

    function updateScrollSpy() {
      if (!trackedPairs.length) return;

      var scrollY = window.pageYOffset || document.documentElement.scrollTop;
      var windowHeight = window.innerHeight;
      var docHeight = document.documentElement.scrollHeight;
      var header = document.querySelector('.fp-site-header');
      var headerHeight = header ? header.offsetHeight : 80;

      // Check if user is scrolled to the very bottom of the page
      if (scrollY + windowHeight >= docHeight - 40) {
        setActiveLink(trackedPairs[trackedPairs.length - 1].link);
        return;
      }

      // Check if user is near the very top (above all tracked sections, e.g. Hero)
      var firstTop = Infinity;
      trackedPairs.forEach(function(p) {
        var top = p.section.getBoundingClientRect().top + scrollY;
        if (top < firstTop) firstTop = top;
      });

      if (scrollY < firstTop - headerHeight - 80) {
        // Clear active state when reading hero at top of page
        setActiveLink(null);
        return;
      }

      // Find which section is currently active based on viewport position
      // Trigger zone is just below the sticky header
      var triggerPoint = headerHeight + 100;
      var activePair = null;

      for (var i = 0; i < trackedPairs.length; i++) {
        var rect = trackedPairs[i].section.getBoundingClientRect();
        if (rect.top <= triggerPoint && rect.bottom > triggerPoint) {
          activePair = trackedPairs[i];
          break;
        }
      }

      // If between sections, choose the section whose top is closest above triggerPoint
      if (!activePair) {
        var bestTop = -Infinity;
        for (var j = 0; j < trackedPairs.length; j++) {
          var r = trackedPairs[j].section.getBoundingClientRect();
          if (r.top <= triggerPoint && r.top > bestTop) {
            bestTop = r.top;
            activePair = trackedPairs[j];
          }
        }
      }

      if (activePair) {
        setActiveLink(activePair.link);
      }
    }

    window.addEventListener('scroll', function() {
      if (!isTicking) {
        window.requestAnimationFrame(function() {
          updateScrollSpy();
          isTicking = false;
        });
        isTicking = true;
      }
    }, { passive: true });

    window.addEventListener('resize', function() {
      if (!isTicking) {
        window.requestAnimationFrame(function() {
          updateScrollSpy();
          isTicking = false;
        });
        isTicking = true;
      }
    }, { passive: true });

    // Initial check on page load
    setTimeout(updateScrollSpy, 100);

    // Theme Toggle (Dark / Light Mode)
    (function() {
      var themeToggleBtn = document.getElementById('theme-toggle');
      var moonIcon = document.querySelector('.dark-icon-moon');
      var sunIcon = document.querySelector('.dark-icon-sun');

      function updateThemeUI(isDark) {
        if (isDark) {
          document.documentElement.classList.add('dark');
          document.documentElement.setAttribute('data-theme', 'dark');
          if (moonIcon) moonIcon.classList.add('hidden');
          if (sunIcon) sunIcon.classList.remove('hidden');
        } else {
          document.documentElement.classList.remove('dark');
          document.documentElement.removeAttribute('data-theme');
          if (moonIcon) moonIcon.classList.remove('hidden');
          if (sunIcon) sunIcon.classList.add('hidden');
        }
      }

      var savedTheme = localStorage.getItem('pixelpost-theme');
      var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      var isDark = savedTheme ? (savedTheme === 'dark') : false; // default to light editorial

      updateThemeUI(isDark);

      if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function(e) {
          e.preventDefault();
          var currentlyDark = document.documentElement.classList.contains('dark');
          var newTheme = currentlyDark ? 'light' : 'dark';
          localStorage.setItem('pixelpost-theme', newTheme);
          updateThemeUI(!currentlyDark);
        });
      }
    })();
  });
})();
