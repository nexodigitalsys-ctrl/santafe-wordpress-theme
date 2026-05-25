/**
 * Navigation.js — Santa Fe Header
 * Architect's Bar scroll effect, mobile menu with accordion submenu
 * iOS-safe scroll lock using overflow:hidden on <html>
 */

document.addEventListener('DOMContentLoaded', function() {
    var header = document.getElementById('site-nav');
    var menuToggle = document.getElementById('menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');
    var menuClose = document.getElementById('menu-close');
    var mobileLinks = document.querySelectorAll('.mobile-nav-link');
    var submenuToggles = document.querySelectorAll('.mobile-submenu-toggle');

    // Header scroll-reveal — Architect's Bar
    if (header) {
        function onScroll() {
            if (window.scrollY > 60) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // Mobile menu — overflow:hidden scroll lock (no reflow, no flash)
    if (menuToggle && mobileMenu) {
        var scrollPosition = 0;

        function openMenu() {
            scrollPosition = window.scrollY;
            document.documentElement.classList.add('menu-open');
            document.body.style.top = '-' + scrollPosition + 'px';
            mobileMenu.classList.add('open');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.addEventListener('keydown', onKeyDown);
            document.addEventListener('click', onClickOutside);
        }

        function closeMenu() {
            mobileMenu.classList.remove('open');
            menuToggle.setAttribute('aria-expanded', 'false');
            // Close any open submenus
            submenuToggles.forEach(function(btn) {
                btn.setAttribute('aria-expanded', 'false');
                var panel = document.getElementById(btn.getAttribute('aria-controls'));
                if (panel) panel.classList.remove('open');
            });
            // Small delay to let slide-out animation start before restoring scroll
            setTimeout(function() {
                document.documentElement.classList.remove('menu-open');
                document.body.style.top = '';
                window.scrollTo(0, scrollPosition);
            }, 50);
            document.removeEventListener('keydown', onKeyDown);
            document.removeEventListener('click', onClickOutside);
        }

        function onKeyDown(e) {
            if (e.key === 'Escape') closeMenu();
        }

        function onClickOutside(e) {
            if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) closeMenu();
        }

        menuToggle.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        mobileLinks.forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    }

    // Mobile submenu accordion
    submenuToggles.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var isExpanded = btn.getAttribute('aria-expanded') === 'true';
            var panelId = btn.getAttribute('aria-controls');
            var panel = document.getElementById(panelId);

            // Close other submenus (optional — single-open accordion)
            submenuToggles.forEach(function(other) {
                if (other !== btn) {
                    other.setAttribute('aria-expanded', 'false');
                    var otherPanel = document.getElementById(other.getAttribute('aria-controls'));
                    if (otherPanel) otherPanel.classList.remove('open');
                }
            });

            if (isExpanded) {
                btn.setAttribute('aria-expanded', 'false');
                if (panel) panel.classList.remove('open');
            } else {
                btn.setAttribute('aria-expanded', 'true');
                if (panel) panel.classList.add('open');
            }
        });
    });
});
