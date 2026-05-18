/**
 * Navigation.js — Santa Fe Header
 * Architect's Bar scroll effect, mobile menu
 * iOS-safe scroll lock using position:fixed technique
 * @see https://css-tricks.com/prevent-page-scrolling-when-a-modal-is-open-on-ios-safari/
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

    // Mobile menu — iOS-safe scroll lock
    if (menuToggle && mobileMenu) {
        var scrollPosition = 0;

        function openMenu() {
            scrollPosition = window.scrollY;
            mobileMenu.classList.add('open');
            menuToggle.setAttribute('aria-expanded', 'true');
            // iOS-safe body scroll lock
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + scrollPosition + 'px';
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.addEventListener('keydown', onKeyDown);
            document.addEventListener('click', onClickOutside);
        }

        function closeMenu() {
            mobileMenu.classList.remove('open');
            menuToggle.setAttribute('aria-expanded', 'false');
            // Restore body scroll
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            window.scrollTo(0, scrollPosition);
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