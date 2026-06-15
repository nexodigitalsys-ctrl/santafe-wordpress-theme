/**
 * Navigation.js — Santa Fe Header
 * Architect's Bar scroll effect, mobile menu with accordion submenu, theme toggle
 * Mobile menu: simple position:fixed modal, no scroll lock hacks
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

    // Mobile menu — simple toggle: click to open, click X to close
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
            // Close any open submenus
            submenuToggles.forEach(function(btn) {
                btn.setAttribute('aria-expanded', 'false');
                var panel = document.getElementById(btn.getAttribute('aria-controls'));
                if (panel) panel.classList.remove('open');
            });
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

    // Theme toggle — Dark / Light mode
    (function() {
        var STORAGE_KEY = 'santafe-theme';
        var html = document.documentElement;
        var desktopBtn = document.getElementById('theme-toggle');
        var mobileBtn = document.getElementById('theme-toggle-mobile');

        function getPreferredTheme() {
            var stored = localStorage.getItem(STORAGE_KEY);
            if (stored === 'dark' || stored === 'light') return stored;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        function setTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            localStorage.setItem(STORAGE_KEY, theme);
            updateIcons(theme);
        }

        function toggleTheme() {
            setTheme(html.classList.contains('dark') ? 'light' : 'dark');
        }

        function updateIcons(theme) {
            var isDark = theme === 'dark';
            // Desktop icons
            var sunD = document.getElementById('theme-icon-sun');
            var moonD = document.getElementById('theme-icon-moon');
            if (sunD) sunD.classList.toggle('hidden', !isDark);
            if (moonD) moonD.classList.toggle('hidden', isDark);
            // Mobile icons
            var sunM = mobileBtn ? mobileBtn.querySelector('.theme-icon-sun') : null;
            var moonM = mobileBtn ? mobileBtn.querySelector('.theme-icon-moon') : null;
            if (sunM) sunM.classList.toggle('hidden', !isDark);
            if (moonM) moonM.classList.toggle('hidden', isDark);
        }

        // Init
        setTheme(getPreferredTheme());

        if (desktopBtn) desktopBtn.addEventListener('click', toggleTheme);
        if (mobileBtn) mobileBtn.addEventListener('click', toggleTheme);

        // Listen for system changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (!localStorage.getItem(STORAGE_KEY)) {
                setTheme(e.matches ? 'dark' : 'light');
            }
        });
    })();
});
