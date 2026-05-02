/**
 * Utils.js — Helpers reutilizables
 * Throttle, debounce, lazy load, utilidades DOM
 */

function throttle(fn, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            fn.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

function debounce(fn, delay) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

function onReady(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

// Lazy loading fallback con IntersectionObserver
onReady(function() {
    if ('loading' in HTMLImageElement.prototype) return;

    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    if (!('IntersectionObserver' in window)) {
        lazyImages.forEach(function(img) {
            if (img.dataset.src) img.src = img.dataset.src;
        });
        return;
    }

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) img.src = img.dataset.src;
                img.removeAttribute('loading');
                observer.unobserve(img);
            }
        });
    }, { rootMargin: '50px 0px' });

    lazyImages.forEach(function(img) {
        if (img.dataset.src) observer.observe(img);
    });
});
