/**
 * Navigation.js — Santa Fe Header
 * Architect's Bar scroll effect, mobile menu
 */

document.addEventListener('DOMContentLoaded', function() {
    var header = document.getElementById('site-nav');
    var menuToggle = document.getElementById('menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');
    var menuClose = document.getElementById('menu-close');
    var mobileLinks = document.querySelectorAll('.mobile-nav-link');

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

    // Mobile menu
    if (menuToggle && mobileMenu) {
        function openMenu() {
            mobileMenu.classList.add('open');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.addEventListener('keydown', onKeyDown);
            document.addEventListener('click', onClickOutside);
        }
        function closeMenu() {
            mobileMenu.classList.remove('open');
            menuToggle.setAttribute('aria-expanded', 'false');
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
});
